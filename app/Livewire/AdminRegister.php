<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\User;

class AdminRegister extends Component
{
    use WithFileUploads;

    public $name, $email, $password, $password_confirmation, $photo;

    public function register()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8|confirmed',
            'photo' => 'nullable|image|max:1024', // Optional image
        ]);

        // If photo is uploaded, store it
        if ($this->photo) {
            $validated['photo'] = $this->photo->store('photos', 'public');
        }

        // Add role and hashed password
        $validated['role'] = 'admin';
        $validated['password'] = Hash::make($validated['password']);

        // Create the user
        User::create($validated);

        // Reset form fields
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'photo']);

        // Redirect to dashboard with success message
        return redirect()->route('admin.dashboard')->with('success', 'New admin registered successfully!');
    }

    public function render()
    {
        return view('livewire.admin-register');
    }
}
