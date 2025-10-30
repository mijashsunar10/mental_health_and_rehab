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
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending')->after('appointment_type');
            $table->string('transaction_id')->nullable()->after('payment_status');
            $table->decimal('payment_amount', 10, 2)->default(1000.00)->after('transaction_id');
            $table->timestamp('payment_date')->nullable()->after('payment_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'transaction_id', 'payment_amount', 'payment_date']);
        });
    }
};
