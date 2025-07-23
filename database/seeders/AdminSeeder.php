<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\UserRole;
use App\Models\User;
Use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' =>  UserRole::Admin,
            'password' => Hash::make('123456789'),

        ]);
    }
}
