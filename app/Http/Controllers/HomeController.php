<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $teamMembers = TeamMember::orderBy('order')->get();
        $faqs = Faq::all();

        return view('frontend.home.index',compact('teamMembers','faqs'));
    }
}
