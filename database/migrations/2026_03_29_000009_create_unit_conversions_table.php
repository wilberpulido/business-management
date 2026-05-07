<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_unit_id')->constrained('units_of_measure');
            $table->foreignId('to_unit_id')->constrained('units_of_measure');
            $table->decimal('factor', 15, 6);
            // null = conversión global estándar (ej: kg → g = 1000)
            // con product_id = conversión específica del producto (ej: 1 caja de tequeños = 12 uds)
            // la conversión específica tiene prioridad sobre la global
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->unique(['from_unit_id', 'to_unit_id', 'product_id'], 'unit_conversions_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_conversions');
    }
};
