<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Mail\PanicAlertMail;

class PanicButtonController extends Controller
{
    public function sendPanicAlert(Request $request)
    {
        try {
            // Get user information
            $user = Auth::user(); // No need to check since middleware ensures auth
            $timestamp = now();
            $ipAddress = $request->ip();
            $userAgent = $request->header('User-Agent');
            $currentUrl = $request->input('url');
            
            // Prepare alert data
            $alertData = [
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_id' => $user->id,
                'timestamp' => $timestamp,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'current_url' => $currentUrl,
                'session_id' => session()->getId(),
            ];
            
            // Log the panic button activation
            Log::emergency('PANIC BUTTON ACTIVATED', $alertData);
            
            // Define emergency contacts (you can move this to config or database)
          $emergencyContacts = [
                'sandeshpahari05@gmail.com',
                'mijashsunar1@gmail.com',
                'sangam.darlami88@gmail.com',
                // Add more emergency contacts as needed
            ];
            
            // Send email to each emergency contact
            foreach ($emergencyContacts as $contact) {
                Mail::to($contact)->send(new PanicAlertMail($alertData));
            }
            
            // You can also add additional notifications here:
            // - SMS alerts
            // - Slack notifications
            // - Push notifications
            // - Database logging for admin dashboard
            
            // Store panic alert in database (optional)
            $this->storePanicAlert($alertData);
            
            return response()->json([
                'success' => true,
                'message' => 'Emergency alert sent successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Panic button error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'error' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send emergency alert'
            ], 500);
        }
    }
    
    private function storePanicAlert($alertData)
    {
        try {
            // You can create a panic_alerts table and model to store these
            // \App\Models\PanicAlert::create($alertData);
            
            // For now, we'll just log it
            Log::info('Panic alert stored', $alertData);
        } catch (\Exception $e) {
            Log::error('Failed to store panic alert: ' . $e->getMessage());
        }
    }
}