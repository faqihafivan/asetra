<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'code',
    'name',
    'category_id',
    'brand',
    'specification',
    'unit',
    'min_stock',
    'location_id',
    'stock',
    'description',
    'photo_path'
])]
class Item extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Relationship with Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    /**
     * Relationship with Location.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class)->withTrashed();
    }

    /**
     * Relationship with ProcurementItems.
     */
    public function procurementItems(): HasMany
    {
        return $this->hasMany(ProcurementItem::class);
    }

    /**
     * Relationship with ItemExits.
     */
    public function itemExits(): HasMany
    {
        return $this->hasMany(ItemExit::class);
    }

    /**
     * Check if stock is low (below minimum stock).
     */
    public function isStockLow(): bool
    {
        return $this->stock <= $this->min_stock;
    }

    /**
     * Generate automatic Item Code.
     */
    public static function generateCode(): string
    {
        $year = date('Y');
        $prefix = "AST-{$year}-";
        
        $lastItem = self::where('code', 'like', "{$prefix}%")
                        ->withTrashed()
                        ->orderBy('code', 'desc')
                        ->first();
                        
        if (!$lastItem) {
            return $prefix . "0001";
        }
        
        $lastNumber = intval(substr($lastItem->code, strlen($prefix)));
        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        
        return $prefix . $nextNumber;
    }
}
