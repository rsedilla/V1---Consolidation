<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the role enum to include 'equipping'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'leader', 'equipping', 'admin') DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, update any 'equipping' roles back to 'leader' to avoid constraint violations
        DB::table('users')->where('role', 'equipping')->update(['role' => 'leader']);
        
        // Then modify the enum back to the original values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'leader', 'admin') DEFAULT 'user'");
    }
};
