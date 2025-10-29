<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\DoctorAvailability;
use Illuminate\Support\Facades\Auth;

class ManageAvailability extends Component
{
    public $availabilities = [];
    public $selectedDate = '';
    public $startTime = '';
    public $endTime = '';
    public $editingId = null;

    public function mount()
    {
        $this->loadAvailabilities();
    }

    public function loadAvailabilities()
    {
        $this->availabilities = DoctorAvailability::where('doctor_id', Auth::id())
            ->where('availability_date', '>=', now()->toDateString())
            ->orderBy('availability_date')
            ->orderBy('start_time')
            ->get();
    }

    public function addAvailability()
    {
        $this->validate([
            'selectedDate' => 'required|date|after_or_equal:today',
            'startTime' => 'required',
            'endTime' => 'required|after:startTime',
        ]);

        // Generate hourly slots
        $start = \Carbon\Carbon::parse($this->startTime);
        $end = \Carbon\Carbon::parse($this->endTime);

        while ($start < $end) {
            $slotEnd = $start->copy()->addHour();

            // Check if slot already exists
            $exists = DoctorAvailability::where('doctor_id', Auth::id())
                ->where('availability_date', $this->selectedDate)
                ->where('start_time', $start->format('H:i:s'))
                ->exists();

            if (!$exists) {
                DoctorAvailability::create([
                    'doctor_id' => Auth::id(),
                    'availability_date' => $this->selectedDate,
                    'start_time' => $start->format('H:i:s'),
                    'end_time' => $slotEnd->format('H:i:s'),
                    'is_available' => true,
                ]);
            }

            $start->addHour();
        }

        $this->reset(['selectedDate', 'startTime', 'endTime']);
        $this->loadAvailabilities();
        session()->flash('success', 'Availability added successfully!');
    }

    public function toggleAvailability($id)
    {
        $availability = DoctorAvailability::findOrFail($id);

        if ($availability->doctor_id !== Auth::id()) {
            return;
        }

        $availability->is_available = !$availability->is_available;
        $availability->save();

        $this->loadAvailabilities();
    }

    public function deleteAvailability($id)
    {
        $availability = DoctorAvailability::findOrFail($id);

        if ($availability->doctor_id !== Auth::id()) {
            return;
        }

        $availability->delete();
        $this->loadAvailabilities();
        session()->flash('success', 'Availability deleted successfully!');
    }

    public function render()
    {
        return view('livewire.doctor.manage-availability');
    }
}
