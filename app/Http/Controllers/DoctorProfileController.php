<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorProfileController extends Controller
{
    public function index()
    {
       $doctors = User::with('doctorProfile')
                      ->where('role', 'doctor')
                      ->get();
                      
        return view('doctors.index', ['doctors' => $doctors]);
    }

 public function create()
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Please login first');
    }
        // Check if user already has a profile
        if (Auth::check() && Auth::user()->doctorProfile) {
            return redirect()->route('doctors.index')
                ->with('error', 'You already have a doctor profile');
        }

        return view('doctors.create', [
            'user' => Auth::user() // Pass current user to view
        ]);
    }

    public function store(Request $request)
    {
        // Check if user already has a profile
        if (Auth::check() && Auth::user()->doctorProfile) {
            return redirect()->route('doctors.index')
                ->with('error', 'You already have a doctor profile');
        }

        $request->validate([
            'specializations' => 'required',
            'qualifications' => 'required',
            'experience' => 'required',
            'phone' => 'required',
            'hospital' => 'required'
        ]);

        // Create profile for the authenticated user
        Auth::user()->doctorProfile()->create([
            'specializations' => $request->specializations,
            'qualifications' => $request->qualifications,
            'experience' => $request->experience,
            'phone' => $request->phone,
            'hospital' => $request->hospital
        ]);

        return redirect()->route('doctors.index')
            ->with('success', 'Doctor profile created successfully');
    }

    public function show($id)
    {
        $doctor = User::with('doctorProfile')->findOrFail($id);
        return view('doctors.show', compact('doctor'));
    }

    public function edit($id)
    {
        $doctor = User::with('doctorProfile')->findOrFail($id);
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'nmc_number' => 'required',
            'specializations' => 'required',
            'qualifications' => 'required',
            'experience' => 'required',
            'phone' => 'required',
            'hospital' => 'required'
        ]);

        $user = User::findOrFail($id);
        
        // Update user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nmc_number' => $request->nmc_number
        ]);

        // Update profile
        $user->doctorProfile()->update([
            'specializations' => $request->specializations,
            'qualifications' => $request->qualifications,
            'experience' => $request->experience,
            'phone' => $request->phone,
            'hospital' => $request->hospital
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->doctorProfile()->delete();
        $user->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully');
    }
}