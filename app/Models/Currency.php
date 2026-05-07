<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'symbol',
    ];

    public function enterprises(): BelongsToMany
    {
        return $this->belongsToMany(Enterprise::class, 'currency_enterprise')
            ->withPivot('is_default')
            ->withTimestamps();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function combos(): HasMany
    {
        return $this->hasMany(Combo::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function priceHistory(): HasMany
    {
        return $this->hasMany(ProductPriceHistory::class);
    }
}
