<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\JaaSService;

class JitsiMeeting extends Component
{
    public $roomName;
    public $userName;
    public $email;
    public $token;
    public $useJaaS = false;

    public function mount($room = 'TestRoom')
    {
        $this->userName = auth()->user() ? auth()->user()->name : 'Guest';
        $this->email = auth()->user() ? auth()->user()->email : 'guest@example.com';

        // Check if JaaS is configured
        $jaasConfigured = env('JAAS_APP_ID') &&
                         env('JAAS_TENANT_ID') &&
                         env('JAAS_KID') &&
                         env('JAAS_PRIVATE_KEY');

        if ($jaasConfigured) {
            // Use JaaS (authenticated)
            $this->useJaaS = true;
            $this->roomName = env('JAAS_TENANT_ID') . '/' . $room;

            try {
                $jaasService = new JaaSService();
                $this->token = $jaasService->generateToken($this->roomName, $this->userName, $this->email);
            } catch (\Exception $e) {
                // If JaaS fails, fallback to free Jitsi
                logger()->error('JaaS token generation failed: ' . $e->getMessage());
                $this->useJaaS = false;
                $this->roomName = 'MentalHealthApp-' . $room . '-' . substr(md5($room), 0, 8);
            }
        } else {
            // Use free Jitsi Meet (no authentication)
            $this->useJaaS = false;
            $this->roomName = 'MentalHealthApp-' . $room . '-' . substr(md5($room), 0, 8);
        }
    }

    public function render()
    {
        $view = $this->useJaaS ? 'livewire.jitsi-meeting' : 'livewire.jitsi-meeting-free';
        return view($view)->layout('layouts.empty');
    }
}