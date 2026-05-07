<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enterprise_id')->constrained()->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained();
            $table->foreignId('unit_of_measure_id')->constrained('units_of_measure');
            $table->string('name');
            $table->string('slug');
            $table->string('type', 20); // raw_material, intermediate, finished
            $table->boolean('has_batches')->default(false);
            $table->decimal('base_price', 12, 4);
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['enterprise_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
