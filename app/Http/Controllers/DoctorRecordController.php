<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\DoctorNote;
use App\Models\Purchase;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DoctorRecordController extends Controller
{
    /**
     * Display patients list and stats.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Get all patients (users with role 'user')
        $patientsQuery = User::where('role', UserRole::User);

        if ($search) {
            $patientsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $patientsQuery->withCount([
            'patientAppointments',
            'patientNotes'
        ])->orderBy('name')->paginate(15);

        // Get quick stats
        $totalPatients = User::where('role', UserRole::User)->count();

        $todaysAppointments = Appointment::where('doctor_id', auth()->id())
            ->whereDate('appointment_date', Carbon::today())
            ->count();

        $pendingNotes = Appointment::where('doctor_id', auth()->id())
            ->where('status', 'completed')
            ->whereDoesntHave('doctorNotes')
            ->count();

        return view('doctor.patients.index', compact(
            'patients',
            'totalPatients',
            'todaysAppointments',
            'pendingNotes'
        ));
    }

    /**
     * Show detailed records for a specific patient.
     */
    public function show(User $patient)
    {
        // Ensure the user is actually a patient
        if ($patient->role !== UserRole::User) {
            abort(404);
        }

        // Get all appointments for this patient
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor', 'doctorNotes'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        // Get all packages/purchases
        $purchases = Purchase::where('user_id', $patient->id)
            ->with(['package', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get all notes (including private - doctors can see all)
        $notes = DoctorNote::where('user_id', $patient->id)
            ->with(['doctor', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate stats
        $stats = [
            'total_appointments' => $appointments->count(),
            'completed_appointments' => $appointments->where('status', 'completed')->count(),
            'upcoming_appointments' => $appointments->filter->isUpcoming()->count(),
            'total_sessions' => $purchases->sum(function ($purchase) {
                if ($purchase->selected_option && is_array($purchase->selected_option)) {
                    return $purchase->selected_option['sessions'] ?? 0;
                }
                return 0;
            }),
            'total_notes' => $notes->count(),
            'follow_up_required' => $notes->where('follow_up_required', true)->count(),
        ];

        // Get timeline data (appointments + notes)
        $timeline = collect()
            ->merge($appointments->map(function ($appointment) {
                return [
                    'type' => 'appointment',
                    'date' => $appointment->appointment_date,
                    'data' => $appointment,
                ];
            }))
            ->merge($notes->map(function ($note) {
                return [
                    'type' => 'note',
                    'date' => $note->created_at,
                    'data' => $note,
                ];
            }))
            ->sortByDesc('date')
            ->values();

        return view('doctor.patients.show', compact(
            'patient',
            'appointments',
            'purchases',
            'notes',
            'stats',
            'timeline'
        ));
    }
}
