<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::rename('sol3_candidates', 'sol_3_candidates');
    }

    public function down(): void
    {
        Schema::rename('sol_3_candidates', 'sol3_candidates');
    }
};
