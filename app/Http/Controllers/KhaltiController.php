<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Services\Payment\Khalti;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReceiptMail;
use Carbon\Carbon;

class KhaltiController extends Controller
{
    /**
     * Initiate Khalti payment for appointment
     */
    public function checkout(Appointment $appointment)
    {
        // Ensure the appointment belongs to the authenticated user
        if ($appointment->patient_id !== Auth::id()) {
            abort(403, 'Unauthorized access to appointment.');
        }

        // Check if payment is already completed
        if ($appointment->payment_status === 'completed') {
            return redirect()->route('appointment.receipt', ['appointment' => $appointment->id])
                ->with('info', 'Payment already completed for this appointment.');
        }

        $patient = Auth::user();

        try {
            $khalti = new Khalti();
            return $khalti->byCustomer(
                $patient->name,
                $patient->email ?? 'noemail@example.com',
                $patient->phone ?? '9800000000'
            )->pay(
                $appointment->payment_amount,
                route('khalti.verification', ['appointment' => $appointment->id]),
                $appointment->id,
                'Appointment #' . $appointment->id . ' - Dr. ' . $appointment->doctor->name
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment initiation failed: ' . $e->getMessage());
        }
    }

    /**
     * Verify Khalti payment and update appointment
     */
    public function verification(Request $request, Appointment $appointment)
    {
        // Ensure the appointment belongs to the authenticated user
        if ($appointment->patient_id !== Auth::id()) {
            abort(403, 'Unauthorized access to appointment.');
        }

        $khalti = new Khalti();

        // Get transaction code from request
        $pidx = $request->query('pidx');
        $status = $request->query('status');

        if (!$pidx) {
            return redirect()->route('home')->with('error', 'Invalid payment verification request.');
        }

        try {
            // Inquiry payment status from Khalti
            $inquiry = $khalti->inquiry($pidx);

            // Check if payment is successful
            if ($khalti->isSuccess($inquiry)) {
                // Update appointment with payment details
                $appointment->update([
                    'payment_status' => 'completed',
                    'transaction_id' => $pidx,
                    'payment_date' => Carbon::now(),
                ]);

                // Send receipt email if user has email
                if ($appointment->patient->email) {
                    try {
                        Mail::to($appointment->patient->email)->send(new AppointmentReceiptMail($appointment));
                    } catch (\Exception $e) {
                        // Log the error but don't fail the payment verification
                        \Log::error('Failed to send receipt email: ' . $e->getMessage());
                    }
                }

                return redirect()->route('appointment.receipt', ['appointment' => $appointment->id])
                    ->with('success', 'Payment successful! Your appointment is confirmed.');
            } else {
                // Payment failed
                $appointment->update([
                    'payment_status' => 'failed',
                ]);

                return redirect()->route('doctor.profile')
                    ->with('error', 'Payment verification failed. Please try booking again.');
            }
        } catch (\Exception $e) {
            return redirect()->route('doctor.profile')
                ->with('error', 'Payment verification error: ' . $e->getMessage());
        }
    }

    /**
     * Display appointment receipt
     */
    public function receipt(Appointment $appointment)
    {
        // Ensure the appointment belongs to the authenticated user or is the doctor
        if ($appointment->patient_id !== Auth::id() && $appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to appointment receipt.');
        }

        // Check if payment is completed
        if ($appointment->payment_status !== 'completed') {
            return redirect()->route('doctor.profile')
                ->with('error', 'Payment not completed for this appointment.');
        }

        return view('appointments.receipt', compact('appointment'));
    }
}
