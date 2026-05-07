<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('batch_id')->nullable()->constrained('product_batches')->nullOnDelete();
            $table->foreignId('user_id')->constrained();
            // sale_item_id: presente en movimientos type=out generados por una venta
            // permite trazar exactamente qué venta causó el descuento de inventario
            $table->foreignId('sale_item_id')->nullable()->constrained('sale_items')->nullOnDelete();
            $table->string('type', 20); // in, out, adjustment, waste
            $table->decimal('quantity', 12, 4);
            $table->foreignId('unit_of_measure_id')->constrained('units_of_measure');
            // unit_cost: costo unitario de compra, presente en type=in
            $table->decimal('unit_cost', 12, 4)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['branch_id', 'product_id', 'type']);
            $table->index(['branch_id', 'product_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
