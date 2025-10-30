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
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear existing data using delete instead of truncate
        DB::table('doctor_availabilities')->delete();

        // Check if the index exists before trying to drop it
        $indexExists = DB::select("SHOW INDEX FROM doctor_availabilities WHERE Key_name = 'doctor_availabilities_doctor_id_day_of_week_start_time_unique'");

        if (!empty($indexExists)) {
            Schema::table('doctor_availabilities', function (Blueprint $table) {
                // Drop the old unique constraint if it exists
                $table->dropIndex('doctor_availabilities_doctor_id_day_of_week_start_time_unique');
            });
        }

        // Check if day_of_week column exists before trying to drop it
        $columnExists = Schema::hasColumn('doctor_availabilities', 'day_of_week');

        Schema::table('doctor_availabilities', function (Blueprint $table) use ($columnExists) {
            // Remove day_of_week column if it exists
            if ($columnExists) {
                $table->dropColumn('day_of_week');
            }

            // Add availability_date column if it doesn't exist
            if (!Schema::hasColumn('doctor_availabilities', 'availability_date')) {
                $table->date('availability_date')->after('doctor_id');
            }

            // Check if unique constraint already exists
            $uniqueExists = DB::select("SHOW INDEX FROM doctor_availabilities WHERE Key_name = 'doctor_avail_date_unique'");

            // Add new unique constraint for specific dates with custom name
            if (empty($uniqueExists)) {
                $table->unique(['doctor_id', 'availability_date', 'start_time'], 'doctor_avail_date_unique');
            }
        });

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_availabilities', function (Blueprint $table) {
            // Drop the new unique constraint
            $table->dropUnique(['doctor_id', 'availability_date', 'start_time']);

            // Remove availability_date column
            $table->dropColumn('availability_date');

            // Add day_of_week column back
            $table->integer('day_of_week')->after('doctor_id');

            // Restore old unique constraint
            $table->unique(['doctor_id', 'day_of_week', 'start_time']);
        });
    }
};
