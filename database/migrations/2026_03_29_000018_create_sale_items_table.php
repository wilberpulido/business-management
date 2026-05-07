<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->cascadeOnDelete();
            // product_id o combo_id: solo uno puede estar presente por ítem
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('combo_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('quantity', 12, 4);
            $table->decimal('unit_price', 12, 4);
            $table->foreignId('unit_of_measure_id')->constrained('units_of_measure');
            $table->decimal('sub_total', 12, 4);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
