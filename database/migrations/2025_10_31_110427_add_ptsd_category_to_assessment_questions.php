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
        // Add 'ptsd' to the category enum
        DB::statement("ALTER TABLE assessment_questions MODIFY COLUMN category ENUM('anxiety', 'depression', 'stress', 'ptsd')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'ptsd' from the category enum
        DB::statement("ALTER TABLE assessment_questions MODIFY COLUMN category ENUM('anxiety', 'depression', 'stress')");
    }
};
