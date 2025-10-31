<?php

namespace Database\Seeders;

use App\Models\AssessmentQuestion;
use Illuminate\Database\Seeder;

class AssessmentQuestionsSeeder extends Seeder
{
    public function run()
    {
        // Clear existing questions to prevent duplicates
        AssessmentQuestion::query()->delete();

        // Using validated clinical assessment scales:
        // Anxiety: GAD-7 (Generalized Anxiety Disorder-7)
        // Depression: PHQ-9 (Patient Health Questionnaire-9) - 7 items selected
        // Stress: PSS-10 (Perceived Stress Scale-10) - 7 items selected
        // PTSD: PCL-5 (PTSD Checklist for DSM-5) - 7 items selected

        $questions = [
            'anxiety' => [
                'Feeling nervous, anxious or on edge',
                'Not being able to stop or control worrying',
                'Worrying too much about different things',
                'Trouble relaxing',
                'Being so restless that it is hard to sit still',
                'Becoming easily annoyed or irritable',
                'Feeling afraid as if something awful might happen',
            ],
            'depression' => [
                'Little interest or pleasure in doing things',
                'Feeling down, depressed or hopeless',
                'Trouble falling asleep, staying asleep, or sleeping too much',
                'Feeling tired or having little energy',
                'Poor appetite or overeating',
                'Feeling bad about yourself - or that you\'re a failure or have let yourself or your family down',
                'Trouble concentrating on things, such as reading the newspaper or watching television',
            ],
            'stress' => [
                'Been upset because of something that happened unexpectedly',
                'Felt that you were unable to control the important things in your life',
                'Felt nervous and stressed',
                'Felt confident about your ability to handle your personal problems',
                'Found that you could not cope with all the things that you had to do',
                'Been able to control irritations in your life',
                'Felt difficulties were piling up so high that you could not overcome them',
            ],
            'ptsd' => [
                'Repeated, disturbing, and unwanted memories of the stressful experience',
                'Repeated, disturbing dreams of the stressful experience',
                'Suddenly feeling or acting as if the stressful experience were actually happening again (as if you were actually back there reliving it)',
                'Feeling very upset when something reminded you of the stressful experience',
                'Having strong physical reactions when something reminded you of the stressful experience (for example, heart pounding, trouble breathing, sweating)',
                'Avoiding memories, thoughts, or feelings related to the stressful experience',
                'Avoiding external reminders of the stressful experience (for example, people, places, conversations, activities, objects, or situations)',
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