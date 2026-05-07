<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItemExcludedComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_item_id',
        'combo_item_id',
        'product_composition_id',
    ];

    public function saleItem(): BelongsTo
    {
        return $this->belongsTo(SaleItem::class);
    }

    /** Presente cuando el sale_item es un combo — indica de qué producto del combo se excluye el componente */
    public function comboItem(): BelongsTo
    {
        return $this->belongsTo(ComboItem::class);
    }

    public function productComposition(): BelongsTo
    {
        return $this->belongsTo(ProductComposition::class);
    }
}
