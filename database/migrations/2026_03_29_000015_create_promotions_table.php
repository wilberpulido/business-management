<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enterprise_id')->constrained()->cascadeOnDelete();
            $table->string('promotable_type');
            $table->unsignedBigInteger('promotable_id');
            $table->string('name');
            $table->string('discount_type', 20); // percentage, fixed
            $table->decimal('discount_value', 12, 4);
            $table->boolean('stackable')->default(false);
            // Bitmask: bit0=Lun, bit1=Mar, bit2=Mié, bit3=Jue, bit4=Vie, bit5=Sáb, bit6=Dom
            // null = aplica todos los días
            $table->unsignedTinyInteger('days_of_week')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index(['promotable_type', 'promotable_id']);
            $table->index(['enterprise_id', 'active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
