<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'contact_name', 'phone', 'email', 'address'])]
class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Relationship with Procurement.
     */
    public function procurements(): HasMany
    {
        return $this->hasMany(Procurement::class);
    }
}
