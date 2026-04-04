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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('monthly_fee', 8, 2)->default(30.00);
            $table->decimal('water_rate', 8, 2)->default(2500);
            $table->decimal('electric_rate', 8, 2)->default(700);
            $table->enum('status', ['vacant', 'occupied'])->default('vacant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
