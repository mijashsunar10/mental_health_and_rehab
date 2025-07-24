<?php
// app/Http/Controllers/DoctorProfileController.php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class DoctorProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    // Show all doctors
    public function index()
    {
        $doctors = User::where('role', 'doctor')
            ->with('doctorProfile')
            ->paginate(10);
            
        return view('doctors.index', compact('doctors'));
    }

    // Show single doctor
    public function show(User $doctor)
    {
        if ($doctor->role !== 'doctor') {
            abort(404);
        }
        
        $doctor->load('doctorProfile');
        return view('doctors.show', compact('doctor'));
    }

    // Show create form
    public function create()
    {
        // Check if profile already exists
        if (auth()->user()->doctorProfile) {
            return redirect()->route('doctor.profile.edit');
        }
        
        return view('doctors.create');
    }

    // Store profile
    public function store(Request $request)
    {
        // Check if profile already exists
        if (auth()->user()->doctorProfile) {
            return redirect()->route('doctor.profile.edit');
        }

        $validated = $request->validate([
            'specialization' => 'required|string|max:255',
            'qualifications' => 'required|string',
            'experience' => 'required|string',
            'bio' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'working_days' => 'required|array',
            'working_days.*' => 'string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('doctor-photos', 'public');
            $validated['photo'] = $path;
        }

        $validated['user_id'] = auth()->id();
        
        DoctorProfile::create($validated);

        return redirect()->route('doctor.profile.show', auth()->id())
            ->with('success', 'Profile created successfully!');
    }

    // Show edit form
    public function edit()
    {
        $profile = auth()->user()->doctorProfile;
        
        if (!$profile) {
            return redirect()->route('doctor.profile.create');
        }
        
        return view('doctors.edit', compact('profile'));
    }

    // Update profile
    public function update(Request $request)
    {
        $profile = auth()->user()->doctorProfile;
        
        if (!$profile) {
            return redirect()->route('doctor.profile.create');
        }

        $validated = $request->validate([
            'specialization' => 'required|string|max:255',
            'qualifications' => 'required|string',
            'experience' => 'required|string',
            'bio' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'working_days' => 'required|array',
            'working_days.*' => 'string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            
            $path = $request->file('photo')->store('doctor-photos', 'public');
            $validated['photo'] = $path;
        }

        $profile->update($validated);

        return redirect()->route('doctor.profile.show', auth()->id())
            ->with('success', 'Profile updated successfully!');
    }
}