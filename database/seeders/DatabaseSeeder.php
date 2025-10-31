<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            DoctorSeeder::class,
            AssessmentQuestionsSeeder::class,
            PackageSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
