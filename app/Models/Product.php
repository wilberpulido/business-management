<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'enterprise_id',
        'currency_id',
        'unit_of_measure_id',
        'name',
        'slug',
        'type',
        'has_batches',
        'base_price',
        'description',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'has_batches' => 'boolean',
            'base_price'  => 'decimal:4',
            'active'      => 'boolean',
        ];
    }

    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function unitOfMeasure(): BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class);
    }

    public function priceHistory(): HasMany
    {
        return $this->hasMany(ProductPriceHistory::class)->orderByDesc('changed_at');
    }

    /** Ingredientes que componen este producto (BOM) */
    public function compositions(): HasMany
    {
        return $this->hasMany(ProductComposition::class, 'parent_product_id');
    }

    /** Productos en cuya receta aparece este producto como ingrediente */
    public function usedIn(): HasMany
    {
        return $this->hasMany(ProductComposition::class, 'child_product_id');
    }

    public function batches(): HasMany
    {
        return $this->hasMany(ProductBatch::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function comboItems(): HasMany
    {
        return $this->hasMany(ComboItem::class);
    }

    public function promotions(): MorphMany
    {
        return $this->morphMany(Promotion::class, 'promotable');
    }

    public function unitConversions(): HasMany
    {
        return $this->hasMany(UnitConversion::class);
    }
}
