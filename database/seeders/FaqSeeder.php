<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How do I book an appointment with a doctor?',
                'answer' => 'You can book an appointment by visiting the Doctors page, selecting your preferred doctor, and choosing an available time slot. You can also chat with Dr. AI for guidance on booking.'
            ],
            [
                'question' => 'What payment methods are accepted?',
                'answer' => 'We accept Khalti for local payments in Nepal and Stripe for international payments. Both methods are secure and easy to use.'
            ],
            [
                'question' => 'How does video consultation work?',
                'answer' => 'Our platform uses Jitsi for secure video consultations. You don\'t need to download any app - just click the video call link at your appointment time and join directly from your browser.'
            ],
            [
                'question' => 'Are my medical records kept private?',
                'answer' => 'Yes, absolutely. All your medical records, appointment history, and doctor notes are kept strictly confidential and can only be accessed by you and your assigned doctors.'
            ],
            [
                'question' => 'What is the panic button feature?',
                'answer' => 'The panic button is an emergency support feature that provides immediate help and contact information for crisis situations. It can be accessed anytime for urgent mental health support.'
            ],
            [
                'question' => 'Can I switch doctors if needed?',
                'answer' => 'Yes, you can book appointments with different doctors based on your needs and their specializations. Your medical history remains accessible to all your healthcare providers on our platform.'
            ],
            [
                'question' => 'How long does each therapy session last?',
                'answer' => 'Standard therapy sessions are 45-60 minutes long. The exact duration may vary based on your package and the type of consultation.'
            ],
            [
                'question' => 'Do you offer therapy in Nepali language?',
                'answer' => 'Yes, many of our therapists are fluent in both English and Nepali. You can specify your language preference when booking an appointment.'
            ],
            [
                'question' => 'What happens if I miss my appointment?',
                'answer' => 'Please try to cancel at least 24 hours in advance. Missed appointments may affect your package sessions. Contact your doctor or our support team to reschedule.'
            ],
            [
                'question' => 'How do mental health assessments work?',
                'answer' => 'Our platform offers self-assessment tools for various conditions. These are screening tools to help understand your mental health. Results should be discussed with a qualified doctor for proper diagnosis.'
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
