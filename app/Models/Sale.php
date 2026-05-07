<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'currency_id',
        'user_id',
        'date',
        'status',
        'subtotal',
        'discount_type',
        'discount_value',
        'total',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date'           => 'datetime',
            'subtotal'       => 'decimal:4',
            'discount_value' => 'decimal:4',
            'total'          => 'decimal:4',
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function appliedPromotions(): HasMany
    {
        return $this->hasMany(SaleAppliedPromotion::class);
    }
}
