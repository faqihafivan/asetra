<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'procurement_id',
    'item_id',
    'quantity',
    'unit_price',
    'subtotal',
    'photo_path'
])]
class ProcurementItem extends Model
{
    use HasFactory;

    /**
     * Relationship with Procurement.
     */
    public function procurement(): BelongsTo
    {
        return $this->belongsTo(Procurement::class);
    }

    /**
     * Relationship with Item.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class)->withTrashed();
    }
}
