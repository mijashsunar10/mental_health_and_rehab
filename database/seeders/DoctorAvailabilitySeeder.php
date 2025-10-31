<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\DoctorAvailability;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DoctorAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all doctors
        $doctors = User::where('role', UserRole::Doctor)->get();

        if ($doctors->isEmpty()) {
            $this->command->warn('No doctors found in database. Please add doctors first.');
            return;
        }

        $this->command->info("Creating availability for {$doctors->count()} doctor(s)...");

        foreach ($doctors as $doctor) {
            // Create availability for next 7 days
            for ($day = 0; $day < 7; $day++) {
                $date = Carbon::today()->addDays($day);

                // Skip Sundays
                if ($date->isSunday()) {
                    continue;
                }

                // Morning slots (9 AM - 12 PM)
                if ($day % 2 === 0) { // Every other day
                    DoctorAvailability::create([
                        'doctor_id' => $doctor->id,
                        'availability_date' => $date,
                        'start_time' => '09:00:00',
                        'end_time' => '10:00:00',
                        'is_available' => true,
                    ]);

                    DoctorAvailability::create([
                        'doctor_id' => $doctor->id,
                        'availability_date' => $date,
                        'start_time' => '10:00:00',
                        'end_time' => '11:00:00',
                        'is_available' => true,
                    ]);

                    DoctorAvailability::create([
                        'doctor_id' => $doctor->id,
                        'availability_date' => $date,
                        'start_time' => '11:00:00',
                        'end_time' => '12:00:00',
                        'is_available' => true,
                    ]);
                }

                // Afternoon slots (2 PM - 5 PM)
                if ($day % 3 !== 0) { // Most days
                    DoctorAvailability::create([
                        'doctor_id' => $doctor->id,
                        'availability_date' => $date,
                        'start_time' => '14:00:00',
                        'end_time' => '15:00:00',
                        'is_available' => true,
                    ]);

                    DoctorAvailability::create([
                        'doctor_id' => $doctor->id,
                        'availability_date' => $date,
                        'start_time' => '15:00:00',
                        'end_time' => '16:00:00',
                        'is_available' => true,
                    ]);

                    DoctorAvailability::create([
                        'doctor_id' => $doctor->id,
                        'availability_date' => $date,
                        'start_time' => '16:00:00',
                        'end_time' => '17:00:00',
                        'is_available' => true,
                    ]);
                }

                // Evening slots (5 PM - 7 PM) - only on weekdays
                if ($date->isWeekday() && $day < 5) {
                    DoctorAvailability::create([
                        'doctor_id' => $doctor->id,
                        'availability_date' => $date,
                        'start_time' => '17:00:00',
                        'end_time' => '18:00:00',
                        'is_available' => true,
                    ]);

                    DoctorAvailability::create([
                        'doctor_id' => $doctor->id,
                        'availability_date' => $date,
                        'start_time' => '18:00:00',
                        'end_time' => '19:00:00',
                        'is_available' => true,
                    ]);
                }
            }

            $this->command->info("✓ Created availability for Dr. {$doctor->name}");
        }

        $totalSlots = DoctorAvailability::count();
        $this->command->info("Total availability slots created: {$totalSlots}");
    }
}
