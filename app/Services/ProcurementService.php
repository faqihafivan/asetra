<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Procurement;
use Illuminate\Support\Facades\DB;

class ProcurementService
{
    /**
     * Create a new procurement transaction.
     *
     * @param  array  $data
     * @param  int  $userId
     * @return \App\Models\Procurement
     * @throws \Exception
     */
    public function createProcurement(array $data, int $userId): Procurement
    {
        return DB::transaction(function () use ($data, $userId) {
            // 1. Generate Automatic Number
            $number = Procurement::generateNumber();

            // 2. Upload Invoice Photos (Multiple)
            $invoicePhotoPaths = [];
            if (isset($data['invoice_photos'])) {
                foreach ($data['invoice_photos'] as $file) {
                    $path = $file->store('invoices', 'public');
                    $invoicePhotoPaths[] = 'storage/' . $path;
                }
            }

            // 3. Create Procurement Header
            $procurement = Procurement::create([
                'number' => $number,
                'date' => $data['date'],
                'supplier_id' => $data['supplier_id'],
                'invoice_number' => $data['invoice_number'],
                'funding_source_id' => $data['funding_source_id'],
                'description' => $data['description'] ?? null,
                'invoice_photos' => $invoicePhotoPaths,
                'created_by' => $userId,
                'total_price' => 0.00, // Will calculate below
            ]);

            $totalPrice = 0.00;

            // 4. Create Procurement Items (Details) & Update Stocks
            foreach ($data['items'] as $itemTrx) {
                $item = Item::findOrFail($itemTrx['item_id']);
                
                $quantity = intval($itemTrx['quantity']);
                $unitPrice = floatval($itemTrx['unit_price']);
                $subtotal = $quantity * $unitPrice;
                $totalPrice += $subtotal;

                // Handle Optional Item Photo during procurement
                $itemPhotoPath = null;
                if (isset($itemTrx['photo'])) {
                    $path = $itemTrx['photo']->store('items', 'public');
                    $itemPhotoPath = 'storage/' . $path;

                    // Update main item photo too
                    $item->update(['photo_path' => $itemPhotoPath]);
                }

                // Create Procurement Item Row
                $procurement->items()->create([
                    'item_id' => $item->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                    'photo_path' => $itemPhotoPath,
                ]);

                // Increment Item Stock
                $item->increment('stock', $quantity);
            }

            // 5. Update header with calculated total price
            $procurement->update(['total_price' => $totalPrice]);

            return $procurement;
        });
    }
}
