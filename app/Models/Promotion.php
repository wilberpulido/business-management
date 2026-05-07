<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'enterprise_id',
        'promotable_type',
        'promotable_id',
        'name',
        'discount_type',
        'discount_value',
        'stackable',
        'days_of_week',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:4',
            'stackable'      => 'boolean',
            'active'         => 'boolean',
            'start_date'     => 'date',
            'end_date'       => 'date',
        ];
    }

    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class);
    }

    public function promotable(): MorphTo
    {
        return $this->morphTo();
    }

    public function appliedToSales(): HasMany
    {
        return $this->hasMany(SaleAppliedPromotion::class);
    }

    /**
     * Verifica si la promoción aplica en un día de la semana dado.
     * $dayOfWeek: 1=Lunes ... 7=Domingo (ISO 8601)
     * days_of_week es un bitmask: bit0=Lun, bit1=Mar, ..., bit6=Dom
     */
    public function appliesOnDay(int $dayOfWeek): bool
    {
        if ($this->days_of_week === null) {
            return true;
        }

        return (bool) ($this->days_of_week & (1 << ($dayOfWeek - 1)));
    }
}
