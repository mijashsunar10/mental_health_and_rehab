<?php

namespace Database\Seeders;

use App\Models\AssessmentQuestion;
use Illuminate\Database\Seeder;

class AssessmentQuestionsSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            'anxiety' => [
                'I felt nervous or anxious',
                'I felt scared for no reason',
                'I had difficulty relaxing',
                'I experienced trembling or shaking',
                'I felt like I was in danger',
                'I had racing thoughts',
                'I felt like something awful might happen',
                'I had trouble sitting still',
                'I felt panicky',
                'I was easily startled',
                'I had difficulty controlling my worry',
                'I felt restless',
                'I had physical symptoms of anxiety (e.g., sweating, pounding heart)',
                'I avoided situations because of anxiety',
                'I had trouble falling or staying asleep due to anxiety',
            ],
            'depression' => [
                'I felt down or depressed',
                'I lost interest in activities I usually enjoy',
                'I felt hopeless about the future',
                'I had trouble concentrating',
                'I felt worthless',
                'I had thoughts of death or suicide',
                'I felt tired or had little energy',
                'I had changes in appetite',
                'I moved or spoke more slowly than usual',
                'I felt guilty or blamed myself',
                'I had difficulty making decisions',
                'I felt irritable or frustrated',
                'I cried more than usual',
                'I felt lonely even when with others',
                'I had trouble getting out of bed',
            ],
            'stress' => [
                'I felt overwhelmed',
                'I had difficulty coping with daily tasks',
                'I felt irritable or angry',
                'I had muscle tension or pain',
                'I felt like I had too much to handle',
                'I had headaches or migraines',
                'I felt like I couldn\'t keep up with everything',
                'I had digestive problems',
                'I felt like I had no time for myself',
                'I had trouble relaxing',
                'I felt like I was under constant pressure',
                'I had changes in sleep patterns',
                'I felt like I couldn\'t control important things in my life',
                'I had difficulty concentrating',
                'I felt like I was on the verge of breaking down',
            ],
        ];

        foreach ($questions as $category => $categoryQuestions) {
            foreach ($categoryQuestions as $index => $question) {
                AssessmentQuestion::create([
                    'category' => $category,
                    'question' => $question,
                    'order' => $index + 1,
                ]);
            }
        }
    }
}