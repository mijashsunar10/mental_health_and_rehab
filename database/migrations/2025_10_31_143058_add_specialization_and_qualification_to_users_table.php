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
        Schema::table('users', function (Blueprint $table) {
            $table->text('specializations')->nullable()->after('nmc_number');
            $table->text('qualifications')->nullable()->after('specializations');
            $table->string('designation')->nullable()->after('qualifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['specializations', 'qualifications', 'designation']);
        });
    }
};
