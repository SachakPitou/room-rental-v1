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
        Schema::table('rooms', function (Blueprint $table) {
            // 'metered' = per m³, 'fixed' = flat fee per month
            $table->enum('water_mode', ['metered', 'fixed'])->default('metered')->after('electric_rate');
            $table->decimal('water_fixed_fee', 8, 2)->default(0)->after('water_mode');
            // water_fixed_fee is in USD (e.g. $2.00/month flat)
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['water_mode', 'water_fixed_fee']);
        });
    }
};
