<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\UserRole;
use App\Models\User;
Use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        User::create([
            'name' => 'Dcotor User',
            'email' => 'doctor@gmail.com',
            'role' =>  UserRole::Doctor,
            'password' => Hash::make('123456789'),

        ]);

    }
}
