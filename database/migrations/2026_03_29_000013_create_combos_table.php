<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('combos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enterprise_id')->constrained()->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained();
            $table->string('name');
            $table->string('slug');
            $table->decimal('price', 12, 4);
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['enterprise_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combos');
    }
};
