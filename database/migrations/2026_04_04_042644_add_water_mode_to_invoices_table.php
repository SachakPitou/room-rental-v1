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
        Schema::table('invoices', function (Blueprint $table) {
            $table->enum('water_mode', ['metered', 'fixed'])->default('metered')->after('water_rate');
            $table->decimal('water_fixed_fee', 8, 2)->default(0)->after('water_mode');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['water_mode', 'water_fixed_fee']);
        });
    }
};
