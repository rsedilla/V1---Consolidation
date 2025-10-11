<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * SOL 1 Table - Stores personal information (like Members table)
     * This is the main record for SOL 1 students
     */
    public function up(): void
    {
        Schema::create('sol_1', function (Blueprint $table) {
            $table->id();
            
            // Personal Information (like members table)
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('birthday')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            
            // Status & Hierarchy
            $table->foreignId('status_id')->constrained('statuses')->onDelete('restrict');
            $table->foreignId('g12_leader_id')->constrained('g12_leaders')->onDelete('restrict');
            
            // Additional Fields
            $table->date('wedding_anniversary_date')->nullable();
            $table->boolean('is_cell_leader')->default(false);
            
            // Source Tracking (optional links)
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            
            // Notes
            $table->text('notes')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for performance
            $table->index('status_id');
            $table->index('g12_leader_id');
            $table->index('member_id');
            $table->index('is_cell_leader');
            $table->index(['first_name', 'last_name']);
            
            // Unique constraints
            $table->unique('email', 'unique_sol1_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sol_1');
    }
};
