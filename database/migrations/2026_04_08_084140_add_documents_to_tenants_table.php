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
            $table->string('id_card_path')->nullable()->after('national_id');
            $table->string('id_card_type')->nullable()->after('id_card_path');
            // id_card_type: 'national_id', 'passport', 'other'
            $table->string('id_card_original_name')->nullable()->after('id_card_type');
            $table->timestamp('id_card_uploaded_at')->nullable()->after('id_card_original_name');
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'id_card_path',
                'id_card_type',
                'id_card_original_name',
                'id_card_uploaded_at',
            ]);
        });
    }
};
