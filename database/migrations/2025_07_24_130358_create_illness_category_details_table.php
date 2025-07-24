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
        Schema::create('illness_category_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('illness_category_id')->constrained('illness_categories')->onDelete('cascade');
            $table->string('hero_image')->nullable();
            $table->text('overview');
            $table->text('symptoms');
            $table->text('types');
            $table->text('treatment');
            $table->text('prevention');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('illness_category_details');
    }
};
