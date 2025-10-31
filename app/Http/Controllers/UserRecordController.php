<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorNote;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class UserRecordController extends Controller
{
    /**
     * Display user's records dashboard.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Get filter parameters
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $doctorId = $request->input('doctor_id');
        $status = $request->input('status');

        // Build appointments query
        $appointmentsQuery = Appointment::where('patient_id', $user->id)
            ->with(['doctor', 'doctorNotes']);

        if ($dateFrom) {
            $appointmentsQuery->where('appointment_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $appointmentsQuery->where('appointment_date', '<=', $dateTo);
        }

        if ($doctorId) {
            $appointmentsQuery->where('doctor_id', $doctorId);
        }

        if ($status) {
            $appointmentsQuery->where('status', $status);
        }

        $appointments = $appointmentsQuery->orderBy('appointment_date', 'desc')
            ->paginate(10);

        // Get packages/purchases
        $purchases = Purchase::where('user_id', $user->id)
            ->with(['package', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get notes (non-private only)
        $notesQuery = DoctorNote::where('user_id', $user->id)
            ->nonPrivate()
            ->with(['doctor', 'appointment']);

        if ($dateFrom) {
            $notesQuery->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $notesQuery->whereDate('created_at', '<=', $dateTo);
        }

        if ($doctorId) {
            $notesQuery->where('doctor_id', $doctorId);
        }

        $notes = $notesQuery->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get unique doctors from appointments for filter dropdown
        $doctors = Appointment::where('patient_id', $user->id)
            ->with('doctor')
            ->get()
            ->pluck('doctor')
            ->unique('id')
            ->sortBy('name');

        return view('records.index', compact(
            'appointments',
            'purchases',
            'notes',
            'doctors'
        ));
    }

    /**
     * Export records to PDF.
     */
    public function exportPdf(Request $request)
    {
        $user = auth()->user();

        // Get filter parameters
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        // Get appointments
        $appointmentsQuery = Appointment::where('patient_id', $user->id)
            ->with(['doctor', 'doctorNotes']);

        if ($dateFrom) {
            $appointmentsQuery->where('appointment_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $appointmentsQuery->where('appointment_date', '<=', $dateTo);
        }

        $appointments = $appointmentsQuery->orderBy('appointment_date', 'desc')->get();

        // Get purchases
        $purchases = Purchase::where('user_id', $user->id)
            ->with(['package', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get notes (non-private only)
        $notesQuery = DoctorNote::where('user_id', $user->id)
            ->nonPrivate()
            ->with(['doctor', 'appointment']);

        if ($dateFrom) {
            $notesQuery->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $notesQuery->whereDate('created_at', '<=', $dateTo);
        }

        $notes = $notesQuery->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('records.pdf', compact(
            'user',
            'appointments',
            'purchases',
            'notes',
            'dateFrom',
            'dateTo'
        ));

        return $pdf->download('medical-records-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }
}
