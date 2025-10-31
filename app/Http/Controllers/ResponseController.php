<?php

namespace App\Http\Controllers;

use App\Models\AssessmentQuestion;
use App\Models\UserResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponseController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'responses' => 'required|array',
            'responses.*.question_id' => 'required|exists:assessment_questions,id',
            'responses.*.response' => 'required|in:0,1,2,3,4',
        ]);

        $user = Auth::user();

        $firstResponse = reset($validated['responses']);
        $question = AssessmentQuestion::find($firstResponse['question_id']);
        $category = $question->category;

        UserResponse::where('user_id', $user->id)
            ->whereHas('question', function($query) use ($category) {
                $query->where('category', $category);
            })
            ->delete();

        foreach ($validated['responses'] as $response) {
            $question = AssessmentQuestion::find($response['question_id']);
            $score = $this->getScoreForResponse($response['response'], $question);

            UserResponse::create([
                'user_id' => $user->id,
                'question_id' => $response['question_id'],
                'response' => $response['response'],
                'score' => $score,
            ]);
        }

        return redirect()->route('assessment.result', ['category' => $category]);
    }

    public function result($category)
    {
        $user = Auth::user();

        $totalScore = UserResponse::where('user_id', $user->id)
            ->whereHas('question', function($query) use ($category) {
                $query->where('category', $category);
            })
            ->sum('score');

        // Use raw scores based on clinical standards
        // Anxiety/Depression: 0-21 scale (7 questions × 0-3 points)
        // Stress/PTSD: 0-28 scale (7 questions × 0-4 points)
        $maxScore = in_array($category, ['stress', 'ptsd']) ? 28 : 21;

        $level = $this->getLevel($totalScore, $category);
        $suggestions = $this->getSuggestions($category, $level);

        return view('assessment.result', compact('category', 'totalScore', 'maxScore', 'level', 'suggestions'));
    }

    private function getScoreForResponse($response, $question)
    {
        $score = (int) $response;

        // Reverse scoring for positive stress items (questions 4 and 6)
        if ($question->category === 'stress' && in_array($question->order, [4, 6])) {
            $score = 4 - $score; // Reverse: 0→4, 1→3, 2→2, 3→1, 4→0
        }

        return $score;
    }

    private function getLevel($score, $category)
    {
        // Clinical thresholds based on validated scales
        if ($category === 'stress') {
            // PSS-10 adapted thresholds (0-28 for 7 questions)
            if ($score <= 9) return 'Low';
            if ($score <= 18) return 'Moderate';
            return 'High';
        } elseif ($category === 'ptsd') {
            // PCL-5 thresholds (0-28 for 7 questions)
            // Adapted from full PCL-5 cutoff of 31-33 out of 80
            if ($score <= 7) return 'Minimal';
            if ($score <= 14) return 'Mild';
            if ($score <= 21) return 'Moderate';
            return 'Severe';
        } else {
            // GAD-7 and PHQ-9 thresholds (0-21 for 7 questions)
            if ($score <= 4) return 'Minimal';
            if ($score <= 9) return 'Mild';
            if ($score <= 14) return 'Moderate';
            return 'Severe';
        }
    }

    private function getSuggestions($category, $level)
    {
        $suggestions = [
            'general' => [
                'Minimal' => [
                    'Your results indicate minimal symptoms. Maintain your healthy habits!',
                    'Consider practicing mindfulness to maintain your good mental health.',
                    'Regular exercise can help continue your positive mental state.'
                ],
                'Low' => [
                    'Your results indicate low stress levels. Keep up your healthy coping strategies!',
                    'Continue to maintain work-life balance and healthy boundaries.',
                    'Regular self-care practices can help you stay resilient.'
                ],
                'Mild' => [
                    'You may be experiencing some symptoms. Monitoring your mood may be helpful.',
                    'Consider stress-reduction techniques like deep breathing exercises.',
                    'Maintaining a regular sleep schedule can help improve your symptoms.'
                ],
                'Moderate' => [
                    'Your results suggest significant symptoms that may benefit from attention.',
                    'Consider talking to a trusted friend or family member about how you\'re feeling.',
                    'Professional counseling might help you develop coping strategies.'
                ],
                'Severe' => [
                    'Your results indicate severe symptoms that would benefit from professional support.',
                    'Please consider reaching out to a mental health professional.',
                    'Crisis support is available if you need immediate help.'
                ],
                'High' => [
                    'Your results indicate high stress levels that need attention.',
                    'Please consider reaching out to a mental health professional for stress management.',
                    'Identifying and addressing major stressors is important for your wellbeing.'
                ]
            ],
            'anxiety' => [
                'Minimal' => [
                    'Your anxiety levels appear to be well managed. Keep up any relaxation practices you\'re using!',
                    'Continue to engage in activities that help you maintain low stress levels.'
                ],
                'Mild' => [
                    'For mild anxiety, regular physical activity can be very helpful.',
                    'Practice grounding techniques when you feel anxious: name 5 things you can see, 4 you can touch, etc.'
                ],
                'Moderate' => [
                    'Consider cognitive behavioral techniques to manage anxious thoughts.',
                    'Limit caffeine and alcohol as these can worsen anxiety symptoms.'
                ],
                'Severe' => [
                    'Please consult with a mental health professional about your anxiety symptoms.',
                    'Consider contacting a crisis line if your anxiety feels overwhelming.'
                ]
            ],
            'depression' => [
                'Minimal' => [
                    'Your mood appears stable. Continue engaging in activities you enjoy.',
                    'Maintaining social connections can help prevent depressive symptoms.'
                ],
                'Mild' => [
                    'For mild low mood, regular routine and sunlight exposure can help.',
                    'Consider keeping a mood journal to track patterns.'
                ],
                'Moderate' => [
                    'Depression at this level may benefit from professional support.',
                    'Try to maintain basic self-care even when you don\'t feel like it.'
                ],
                'Severe' => [
                    'Please reach out for professional help - depression is treatable.',
                    'If you have thoughts of self-harm, contact emergency services immediately.'
                ]
            ],
            'stress' => [
                'Low' => [
                    'You seem to be managing stress well. Continue your healthy coping strategies.',
                    'Regular breaks during work can help maintain low stress levels.'
                ],
                'Mild' => [
                    'For mild stress, time management techniques may be helpful.',
                    'Practice saying no to additional commitments when you feel stretched thin.'
                ],
                'Moderate' => [
                    'Consider identifying and addressing major sources of stress in your life.',
                    'Progressive muscle relaxation can help relieve physical stress symptoms.'
                ],
                'High' => [
                    'Chronic high stress can impact physical health - please seek support.',
                    'Consider professional help to develop a stress management plan.'
                ]
            ],
            'ptsd' => [
                'Minimal' => [
                    'You are showing minimal PTSD symptoms. Continue using healthy coping mechanisms.',
                    'Staying connected with supportive people can help maintain resilience.'
                ],
                'Mild' => [
                    'Some trauma-related symptoms are present. Consider talking to someone you trust.',
                    'Grounding techniques and mindfulness can help manage intrusive thoughts.'
                ],
                'Moderate' => [
                    'Your symptoms suggest you may benefit from professional trauma-informed therapy.',
                    'Evidence-based treatments like CPT or EMDR are effective for PTSD symptoms.',
                    'Consider reaching out to a trauma specialist or mental health professional.'
                ],
                'Severe' => [
                    'Your results indicate significant PTSD symptoms that require professional support.',
                    'Please seek help from a mental health professional experienced in trauma treatment.',
                    'If you are in crisis or having thoughts of self-harm, call 988 (Suicide & Crisis Lifeline) immediately.',
                    'PTSD is treatable - specialized therapy can help you recover.'
                ]
            ]
        ];

        // Combine general suggestions with category-specific ones
        return array_merge(
            $suggestions['general'][$level] ?? [],
            $suggestions[$category][$level] ?? []
        );
    }
}