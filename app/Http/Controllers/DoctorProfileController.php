<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Enums\UserRole;

class DoctorProfileController extends Controller
{
    public function __construct()
    {
        // Apply auth middleware to all methods except index and show
        // $this->middleware('auth')->except(['index', 'show']);
        
        // Additional check for doctor role on create/store/edit/update
        // $this->middleware(function ($request, $next) {
        //     if (auth()->check() && auth()->user()->role !== UserRole::Doctor->value) {
        //         return redirect()->route('dashboard');
        //     }
        //     return $next($request);
        // })->only(['create', 'store', 'edit', 'update']);
    }

    // Show all doctors (public)
    public function index()
    {
        $doctors = User::where('role', UserRole::Doctor->value)
            ->with('doctorProfile')
            ->paginate(10);
            
        return view('doctor.profile.index', compact('doctors'));
    }

    // Show single doctor (public)
    public function show(User $doctor)
    {
        if ($doctor->role !== UserRole::Doctor->value) {
            abort(404);
        }
        
        $doctor->load('doctorProfile');
        return view('doctor.profile.show', compact('doctor'));
    }

    // Show create form (doctor auth only)
    public function create()
    {
        if (auth()->user()->doctorProfile) {
            return redirect()->route('doctor.profile.edit');
        }
        
        return view('doctor.profile.create');
    }

    // Store profile (doctor auth only)
    public function store(Request $request)
    {
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

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('doctor-photos', 'public');
            $validated['photo'] = $path;
        }

        $validated['user_id'] = auth()->id();
        
        DoctorProfile::create($validated);

        return redirect()->route('doctor.profile.show', auth()->id())
            ->with('success', 'Profile created successfully!');
    }

    // Show edit form (doctor auth only)
    public function edit()
    {
        $profile = auth()->user()->doctorProfile;
        
        if (!$profile) {
            return redirect()->route('doctor.profile.create');
        }
        
        return view('doctor.profile.edit', compact('profile'));
    }

    // Update profile (doctor auth only)
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

        if ($request->hasFile('photo')) {
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