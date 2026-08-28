<?php

namespace App\Notifications;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowStockAlert extends Notification
{
    use Queueable;

    protected $item;

    /**
     * Create a new notification instance.
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'item_id' => $this->item->id,
            'item_code' => $this->item->code,
            'item_name' => $this->item->name,
            'stock' => $this->item->stock,
            'min_stock' => $this->item->min_stock,
            'unit' => $this->item->unit,
            'message' => "Stok barang '{$this->item->name}' ({$this->item->code}) menipis! Stok saat ini: {$this->item->stock} {$this->item->unit} (Batas minimal: {$this->item->min_stock} {$this->item->unit})."
        ];
    }
}
