<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DoctorRegister extends Component
{
    public $name, $email, $password, $password_confirmation, $nmc_number, $phone, $address, $dob, $designation;
    public $specializations = [];
    public $qualifications = [];
    public $newSpecialization = '';
    public $newQualification = '';

    public function addSpecialization()
    {
        if (!empty($this->newSpecialization)) {
            $this->specializations[] = $this->newSpecialization;
            $this->newSpecialization = '';
        }
    }

    public function removeSpecialization($index)
    {
        unset($this->specializations[$index]);
        $this->specializations = array_values($this->specializations);
    }

    public function addQualification()
    {
        if (!empty($this->newQualification)) {
            $this->qualifications[] = $this->newQualification;
            $this->newQualification = '';
        }
    }

    public function removeQualification($index)
    {
        unset($this->qualifications[$index]);
        $this->qualifications = array_values($this->qualifications);
    }

      public function register()
    {
        // Validate inputs
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|confirmed',
            'nmc_number' => 'required|string|max:255',
            'designation' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'dob' => ['nullable', 'date'],

        ]);

        // Create doctor user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'doctor',
            'nmc_number' => $this->nmc_number,
            'designation' => $this->designation,
            'specializations' => $this->specializations,
            'qualifications' => $this->qualifications,
            'phone' => $this->phone,
            'address' => $this->address,
            'dob' => $this->dob,
        ]);

        // // Log in the new admin
        // Auth::login($user);

        // // Redirect with success message
        // return redirect('/admin/dashboard')->with('success', 'Admin registered successfully!');

        // Clear form
        $this->reset(['name', 'email', 'password', 'password_confirmation','nmc_number', 'designation', 'specializations', 'qualifications', 'phone', 'address', 'dob']);

        // Show success message and stay on same page
        return redirect()->route('admin.dashboard')->with('success', 'New doctor registered successfully!');
    
    }
    public function render()
    {
        return view('livewire.doctor-register');
    }
}
