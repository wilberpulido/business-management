<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained();
            $table->foreignId('user_id')->constrained();
            // timestamp completo requerido para evaluar promociones por hora (happy hour)
            $table->timestamp('date');
            $table->string('status', 20)->default('completed'); // completed, voided, pending
            $table->decimal('subtotal', 12, 4);
            $table->string('discount_type', 20)->nullable(); // percentage, fixed
            $table->decimal('discount_value', 12, 4)->nullable();
            $table->decimal('total', 12, 4);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['branch_id', 'date']);
            $table->index(['branch_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
