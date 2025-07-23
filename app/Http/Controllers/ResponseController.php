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
            'responses.*.response' => 'required|in:never,rarely,sometimes,often',
        ]);

        $user = Auth::user();
        
        $firstResponse = reset($validated['responses']);
        $category = AssessmentQuestion::find($firstResponse['question_id'])->category;

        UserResponse::where('user_id', $user->id)
            ->whereHas('question', function($query) use ($category) {
                $query->where('category', $category);
            })
            ->delete();

        foreach ($validated['responses'] as $response) {
            $score = $this->getScoreForResponse($response['response']);
            
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

        $maxScore = AssessmentQuestion::where('category', $category)->count() * 3;
        $normalizedScore = round(($totalScore / $maxScore) * 20);

        $level = $this->getLevel($normalizedScore);
        $suggestions = $this->getSuggestions($category, $level);

        return view('assessment.result', compact('category', 'normalizedScore', 'level', 'suggestions'));
    }

    private function getScoreForResponse($response)
    {
        return match($response) {
            'never' => 0,
            'rarely' => 1,
            'sometimes' => 2,
            'often' => 3,
            default => 0,
        };
    }

    private function getLevel($score)
    {
        if ($score <= 5) return 'Low';
        if ($score <= 10) return 'Mild';
        if ($score <= 15) return 'Moderate';
        return 'High';
    }

    private function getSuggestions($category, $level)
    {
        $suggestions = [
            'general' => [
                'Low' => [
                    'Your results indicate minimal symptoms. Maintain your healthy habits!',
                    'Consider practicing mindfulness to maintain your good mental health.',
                    'Regular exercise can help continue your positive mental state.'
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
                'High' => [
                    'Your results indicate severe symptoms that would benefit from professional support.',
                    'Please consider reaching out to a mental health professional.',
                    'Crisis support is available if you need immediate help.'
                ]
            ],
            'anxiety' => [
                'Low' => [
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
                'High' => [
                    'Please consult with a mental health professional about your anxiety symptoms.',
                    'Consider contacting a crisis line if your anxiety feels overwhelming.'
                ]
            ],
            'depression' => [
                'Low' => [
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
                'High' => [
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
            ]
        ];

        // Combine general suggestions with category-specific ones
        return array_merge(
            $suggestions['general'][$level] ?? [],
            $suggestions[$category][$level] ?? []
        );
    }
}