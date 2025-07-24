<?php
namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class DoctorList extends Component
{
    public function render()
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('livewire.doctor-list', [
            "doctors" => $doctors,
        ]);
    }

    public function suspend($doctorId)
    {
        $doctor = User::find($doctorId);
        if($doctor->isSuspended()) {
            $doctor->unsuspended();
            session()->flash("success","Doctor unsuspended");
        } else {
            $doctor->suspend();
            session()->flash("success","Doctor suspended");
        }
    }

    public function delete($doctorId)
    {
        $doctor = User::find($doctorId);
        $doctor->delete();
        session()->flash("success","Doctor deleted successfully");
    }
}