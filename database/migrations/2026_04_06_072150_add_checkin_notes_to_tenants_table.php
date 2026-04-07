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
        Schema::table('tenants', function (Blueprint $table) {
            $table->time('check_in_time')->nullable()->after('move_in_date');
            $table->time('check_out_time')->nullable()->after('move_out_date');
            $table->text('notes')->nullable()->after('check_out_time');
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['check_in_time', 'check_out_time', 'notes']);
        });
    }
};
