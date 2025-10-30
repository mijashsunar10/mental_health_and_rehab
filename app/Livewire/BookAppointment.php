<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\DoctorAvailability;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookAppointment extends Component
{
    public $doctorId;
    public $doctor;
    public $selectedDate;
    public $selectedSlot;
    public $patientNotes = '';
    public $availableDates = [];
    public $availableSlots = [];
    public $showModal = false;

    public function mount($doctorId)
    {
        $this->doctorId = $doctorId;
        $this->doctor = User::findOrFail($doctorId);
        $this->generateAvailableDates();
    }

    public function generateAvailableDates()
    {
        // Get distinct dates where doctor has availability
        $availabilities = DoctorAvailability::where('doctor_id', $this->doctorId)
            ->where('availability_date', '>=', Carbon::today())
            ->where('is_available', true)
            ->distinct()
            ->pluck('availability_date')
            ->sort();

        $dates = [];
        foreach ($availabilities as $date) {
            $carbonDate = Carbon::parse($date);
            $dates[] = [
                'date' => $carbonDate->format('Y-m-d'),
                'display' => $carbonDate->format('D, M j'),
            ];
        }

        $this->availableDates = $dates;
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->selectedSlot = null;
        $this->loadAvailableSlots();
    }

    public function loadAvailableSlots()
    {
        if (!$this->selectedDate) {
            return;
        }

        // Get doctor's availability for this specific date
        $doctorSlots = DoctorAvailability::where('doctor_id', $this->doctorId)
            ->where('availability_date', $this->selectedDate)
            ->where('is_available', true)
            ->orderBy('start_time')
            ->get();

        // Get already booked appointments for this date
        $bookedSlots = Appointment::where('doctor_id', $this->doctorId)
            ->where('appointment_date', $this->selectedDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('start_time')
            ->toArray();

        $slots = [];
        foreach ($doctorSlots as $slot) {
            $isBooked = in_array($slot->start_time, $bookedSlots);

            $slots[] = [
                'start_time' => $slot->start_time,
                'end_time' => $slot->end_time,
                'display' => Carbon::parse($slot->start_time)->format('g:i A') . ' - ' . Carbon::parse($slot->end_time)->format('g:i A'),
                'is_booked' => $isBooked,
            ];
        }

        $this->availableSlots = $slots;
    }

    public function selectSlot($startTime)
    {
        // Check if slot is not booked
        foreach ($this->availableSlots as $slot) {
            if ($slot['start_time'] === $startTime && !$slot['is_booked']) {
                $this->selectedSlot = $startTime;
                break;
            }
        }
    }

    public function openBookingModal()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!$this->selectedDate || !$this->selectedSlot) {
            session()->flash('error', 'Please select a date and time slot.');
            return;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->patientNotes = '';
    }

    public function bookAppointment()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'patientNotes' => 'nullable|string|max:1000',
        ]);

        // Double check slot is still available
        $existingAppointment = Appointment::where('doctor_id', $this->doctorId)
            ->where('appointment_date', $this->selectedDate)
            ->where('start_time', $this->selectedSlot)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existingAppointment) {
            session()->flash('error', 'This slot has just been booked. Please select another time.');
            $this->loadAvailableSlots();
            return;
        }

        // Find the end time from doctor availability
        $availability = DoctorAvailability::where('doctor_id', $this->doctorId)
            ->where('start_time', $this->selectedSlot)
            ->first();

        Appointment::create([
            'doctor_id' => $this->doctorId,
            'patient_id' => Auth::id(),
            'appointment_date' => $this->selectedDate,
            'start_time' => $this->selectedSlot,
            'end_time' => $availability->end_time,
            'status' => 'pending',
            'patient_notes' => $this->patientNotes,
        ]);

        session()->flash('success', 'Appointment booked successfully!');
        $this->closeModal();
        $this->selectedDate = null;
        $this->selectedSlot = null;
        $this->availableSlots = [];
    }

    public function render()
    {
        return view('livewire.book-appointment');
    }
}
