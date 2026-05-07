<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_price_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained();
            $table->decimal('price', 12, 4);
            // changed_by: quién realizó el cambio de precio
            $table->foreignId('changed_by')->constrained('users');
            // changed_at: fecha efectiva desde la que aplica el precio
            // puede ser futura para programar cambios de precio por adelantado
            $table->timestamp('changed_at');
            $table->timestamps();

            $table->index(['product_id', 'changed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_price_history');
    }
};
