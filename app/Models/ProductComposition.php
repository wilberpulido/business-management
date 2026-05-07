<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductComposition extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_product_id',
        'child_product_id',
        'quantity',
        'unit_of_measure_id',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'parent_product_id');
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'child_product_id');
    }

    public function unitOfMeasure(): BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class);
    }

    public function exclusions(): HasMany
    {
        return $this->hasMany(SaleItemExcludedComponent::class, 'product_composition_id');
    }
}
