<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DoctorProfileController extends Controller
{
    use AuthorizesRequests;
 
    public function index()
{
    $doctors = \App\Models\DoctorProfile::with('user')->latest()->get();
    return view('doctor.profile.index', compact('doctors'));
}

    public function show($id)
    {
        $profile = DoctorProfile::where('user_id', $id)->firstOrFail();
        return view('doctor.profile.show', compact('profile'));
    }

    public function edit()
    {
        $user = Auth::user();

        $this->authorize('edit-own-profile', $user);

        $profile = DoctorProfile::firstOrCreate(['user_id' => $user->id]);

        return view('doctor.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $this->authorize('edit-own-profile', $user);

        $request->validate([
            'specialization' => 'required|string|max:255',
            'education' => 'nullable|string',
            'experience' => 'nullable|string',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048'
        ]);

        $profile = DoctorProfile::firstOrCreate(['user_id' => $user->id]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('doctor_profiles', 'public');
            $profile->profile_image = $path;
        }

        $profile->fill($request->only(['specialization', 'education', 'experience', 'bio']))->save();

        return redirect()->route('doctor.profile.show', $user->id)->with('success', 'Profile updated successfully.');
    }
}
