<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'title' => 'Basic Therapy Package (Online)',
                'description' => 'Perfect for those starting their mental health journey. Includes initial assessment and follow-up sessions with experienced therapists via video consultation.',
                'type' => 'online',
                'options' => [
                    [
                        'sessions' => '4 sessions',
                        'price' => 5000,
                        'duration' => '1 month'
                    ]
                ]
            ],
            [
                'title' => 'Standard Counseling Package (Online)',
                'description' => 'Comprehensive support for ongoing mental health needs. Regular online sessions with dedicated counselor and progress tracking.',
                'type' => 'online',
                'options' => [
                    [
                        'sessions' => '8 sessions',
                        'price' => 9000,
                        'duration' => '2 months'
                    ]
                ]
            ],
            [
                'title' => 'Premium Wellness Package (Online)',
                'description' => 'Complete mental health care with video consultations, priority scheduling, and holistic wellness support.',
                'type' => 'online',
                'options' => [
                    [
                        'sessions' => '12 sessions',
                        'price' => 15000,
                        'duration' => '3 months'
                    ]
                ]
            ],
            [
                'title' => 'In-Person Therapy Package',
                'description' => 'Face-to-face therapy sessions at our clinic. Specialized program for managing anxiety, stress, and related conditions.',
                'type' => 'offline',
                'options' => [
                    [
                        'sessions' => '6 sessions',
                        'price' => 8000,
                        'duration' => '6 weeks'
                    ]
                ]
            ],
            [
                'title' => 'Intensive Offline Support Package',
                'description' => 'Comprehensive in-person therapy for depression and serious mental health concerns with personalized treatment plans.',
                'type' => 'offline',
                'options' => [
                    [
                        'sessions' => '10 sessions',
                        'price' => 14000,
                        'duration' => '10 weeks'
                    ]
                ]
            ],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}
