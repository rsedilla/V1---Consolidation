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
        Schema::table('sunday_services', function (Blueprint $table) {
            // Only add columns if they don't exist
            if (!Schema::hasColumn('sunday_services', 'sunday_service_1_date')) {
                $table->date('sunday_service_1_date')->nullable()->after('member_id');
            }
            if (!Schema::hasColumn('sunday_services', 'sunday_service_2_date')) {
                $table->date('sunday_service_2_date')->nullable()->after('sunday_service_1_date');
            }
            if (!Schema::hasColumn('sunday_services', 'sunday_service_3_date')) {
                $table->date('sunday_service_3_date')->nullable()->after('sunday_service_2_date');
            }
            if (!Schema::hasColumn('sunday_services', 'sunday_service_4_date')) {
                $table->date('sunday_service_4_date')->nullable()->after('sunday_service_3_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sunday_services', function (Blueprint $table) {
            // Remove session columns
            $table->dropColumn([
                'sunday_service_1_date',
                'sunday_service_2_date', 
                'sunday_service_3_date',
                'sunday_service_4_date'
            ]);
        });
    }
};
