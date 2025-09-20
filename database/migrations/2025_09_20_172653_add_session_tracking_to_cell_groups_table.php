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
        Schema::table('cell_groups', function (Blueprint $table) {
            // Add 4 Cell Group session date columns
            $table->date('cell_group_1_date')->nullable()->after('member_id');
            $table->date('cell_group_2_date')->nullable()->after('cell_group_1_date');
            $table->date('cell_group_3_date')->nullable()->after('cell_group_2_date');
            $table->date('cell_group_4_date')->nullable()->after('cell_group_3_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cell_groups', function (Blueprint $table) {
            // Remove session columns
            $table->dropColumn([
                'cell_group_1_date',
                'cell_group_2_date', 
                'cell_group_3_date',
                'cell_group_4_date'
            ]);
        });
    }
};
