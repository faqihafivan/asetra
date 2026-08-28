<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'number',
    'date',
    'supplier_id',
    'invoice_number',
    'funding_source_id',
    'total_price',
    'description',
    'invoice_photos',
    'created_by'
])]
class Procurement extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'invoice_photos' => 'array',
        ];
    }

    /**
     * Relationship with Supplier.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class)->withTrashed();
    }

    /**
     * Relationship with FundingSource.
     */
    public function fundingSource(): BelongsTo
    {
        return $this->belongsTo(FundingSource::class)->withTrashed();
    }

    /**
     * Relationship with User (Creator).
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

    /**
     * Relationship with ProcurementItems (Details).
     */
    public function items(): HasMany
    {
        return $this->hasMany(ProcurementItem::class);
    }

    /**
     * Generate automatic Procurement Transaction Number.
     */
    public static function generateNumber(): string
    {
        $date = date('Ymd');
        $prefix = "PRQ-{$date}-";
        
        $lastProc = self::where('number', 'like', "{$prefix}%")
                        ->withTrashed()
                        ->orderBy('number', 'desc')
                        ->first();
                        
        if (!$lastProc) {
            return $prefix . "0001";
        }
        
        $lastNumber = intval(substr($lastProc->number, strlen($prefix)));
        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        
        return $prefix . $nextNumber;
    }
}
