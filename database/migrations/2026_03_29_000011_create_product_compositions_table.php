<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_compositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('child_product_id')->constrained('products');
            $table->decimal('quantity', 12, 4);
            $table->foreignId('unit_of_measure_id')->constrained('units_of_measure');
            $table->timestamps();

            $table->unique(['parent_product_id', 'child_product_id'], 'product_compositions_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_compositions');
    }
};
