<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DoctorProfileController extends Controller
{
    //
    public function index()
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('doctor.index', compact('doctors'));
    }

    public function show($id)
    {
        $doctor = User::findOrFail($id);
        return view('doctor.show', compact('doctor'));
    }
}
