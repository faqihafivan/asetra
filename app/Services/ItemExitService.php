<?php

namespace App\Services;

use App\Models\Item;
use App\Models\ItemExit;
use App\Models\User;
use App\Notifications\LowStockAlert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ItemExitService
{
    /**
     * Create an item exit transaction.
     *
     * @param  array  $data
     * @param  int  $userId
     * @return \App\Models\ItemExit
     * @throws \Exception
     */
    public function createItemExit(array $data, int $userId): ItemExit
    {
        return DB::transaction(function () use ($data, $userId) {
            // Find item and lock it for update to prevent race conditions in concurrent transactions
            $item = Item::lockForUpdate()->findOrFail($data['item_id']);
            
            $quantity = intval($data['quantity']);

            // 1. Check stock availability
            if ($item->stock < $quantity) {
                throw new \Exception("Stok barang '{$item->name}' tidak mencukupi. Stok saat ini: {$item->stock} {$item->unit}, jumlah dikeluarkan: {$quantity} {$item->unit}.");
            }

            // 2. Create Item Exit Record
            $itemExit = ItemExit::create([
                'date' => $data['date'],
                'item_id' => $item->id,
                'quantity' => $quantity,
                'destination' => $data['destination'],
                'pic' => $data['pic'],
                'description' => $data['description'] ?? null,
                'created_by' => $userId,
            ]);

            // 3. Decrement stock
            $item->decrement('stock', $quantity);

            // 4. Trigger Low Stock Alert Notification if stock <= min_stock
            if ($item->isStockLow()) {
                $users = User::all();
                try {
                    Notification::send($users, new LowStockAlert($item));
                } catch (\Exception $e) {
                    // Fail silently for notification errors so transaction is not blocked
                }
            }

            return $itemExit;
        });
    }
}
