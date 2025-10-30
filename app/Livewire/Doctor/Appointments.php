<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\DoctorAvailability;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Appointments extends Component
{
    public $filter = 'upcoming'; // upcoming, past, all
    public $selectedAppointment = null;
    public $showDetailsModal = false;

    public function mount()
    {
        // Load appointments on mount
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function getAppointmentsProperty()
    {
        $query = Appointment::where('doctor_id', Auth::id())
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc');

        if ($this->filter === 'upcoming') {
            $query->where(function($q) {
                $q->where('appointment_date', '>', now()->toDateString())
                  ->orWhere(function($q2) {
                      $q2->where('appointment_date', now()->toDateString())
                         ->where('start_time', '>=', now()->toTimeString());
                  });
            })->whereIn('status', ['pending', 'confirmed']);
        } elseif ($this->filter === 'past') {
            $query->where(function($q) {
                $q->where('appointment_date', '<', now()->toDateString())
                  ->orWhere(function($q2) {
                      $q2->where('appointment_date', now()->toDateString())
                         ->where('end_time', '<', now()->toTimeString());
                  });
            });
        }

        return $query->get();
    }

    public function viewDetails($appointmentId)
    {
        $this->selectedAppointment = Appointment::with('patient')->findOrFail($appointmentId);
        $this->showDetailsModal = true;
    }

    public function closeModal()
    {
        $this->showDetailsModal = false;
        $this->selectedAppointment = null;
    }

    public function updateStatus($appointmentId, $status)
    {
        $appointment = Appointment::where('doctor_id', Auth::id())
            ->findOrFail($appointmentId);

        $appointment->status = $status;
        $appointment->save();

        // Remove availability slot when appointment is completed or cancelled
        if (in_array($status, ['completed', 'cancelled'])) {
            DoctorAvailability::where('doctor_id', $appointment->doctor_id)
                ->where('availability_date', $appointment->appointment_date)
                ->where('start_time', $appointment->start_time)
                ->delete();
        }

        session()->flash('success', 'Appointment status updated successfully!');
        $this->closeModal();
    }

    public function addNotes($appointmentId, $notes)
    {
        $appointment = Appointment::where('doctor_id', Auth::id())
            ->findOrFail($appointmentId);

        $appointment->notes = $notes;
        $appointment->save();

        session()->flash('success', 'Notes saved successfully!');
    }

    public function render()
    {
        return view('livewire.doctor.appointments', [
            'appointments' => $this->appointments,
        ]);
    }
}
