<?php

namespace App\Http\Controllers;

use App\Models\AssessmentQuestion;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function show($category)
    {
        if (!in_array($category, ['anxiety', 'depression', 'stress'])) {
            abort(404);
        }

        $questions = AssessmentQuestion::where('category', $category)
            ->orderBy('order')
            ->get();

        return view('assessment.show', compact('questions', 'category'));
    }

    public function index()
    {
        $categories = ['anxiety', 'depression', 'stress'];
        return view('assessment.index', compact('categories'));
    }
}