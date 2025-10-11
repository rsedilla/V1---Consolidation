<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Add wedding_anniversary_date to members table (for Member VIP)
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->date('wedding_anniversary_date')->nullable()->after('birthday');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('wedding_anniversary_date');
        });
    }
};
