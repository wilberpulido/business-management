<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_item_excluded_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_item_id')->constrained()->cascadeOnDelete();
            // combo_item_id: requerido cuando sale_item es un combo
            // indica de cuál producto del combo se excluye el componente BOM
            $table->foreignId('combo_item_id')->nullable()->constrained('combo_items')->nullOnDelete();
            $table->foreignId('product_composition_id')->constrained('product_compositions')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_item_excluded_components');
    }
};
