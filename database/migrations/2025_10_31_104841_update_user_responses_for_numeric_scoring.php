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
        Schema::table('user_responses', function (Blueprint $table) {
            // Change response column from enum to string to support numeric values (0-4)
            $table->string('response', 1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_responses', function (Blueprint $table) {
            // Revert back to original enum values
            $table->enum('response', ['never', 'rarely', 'sometimes', 'often'])->change();
        });
    }
};
