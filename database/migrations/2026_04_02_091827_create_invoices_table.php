<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained();
            $table->foreignId('tenant_id')->constrained();
            $table->string('month');                        // "2025-04"
            $table->decimal('monthly_fee', 8, 2);
            $table->decimal('prev_water', 8, 2);
            $table->decimal('curr_water', 8, 2);
            $table->decimal('water_rate', 8, 2);
            $table->decimal('water_used', 8, 2);
            $table->decimal('water_fee_riel', 10, 2);
            $table->decimal('water_fee_usd', 8, 2);
            $table->decimal('prev_electric', 8, 2);
            $table->decimal('curr_electric', 8, 2);
            $table->decimal('electric_rate', 8, 2);
            $table->decimal('electric_used', 8, 2);
            $table->decimal('electric_fee_riel', 10, 2);
            $table->decimal('electric_fee_usd', 8, 2);
            $table->decimal('extra_fee', 8, 2)->default(0);
            $table->string('extra_fee_note')->nullable();
            $table->decimal('exchange_rate', 8, 2)->default(4100);
            $table->decimal('total_usd', 8, 2);
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->date('paid_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
