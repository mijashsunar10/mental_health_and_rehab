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

    public function mount($room = 'TestRoom')
    {
        $this->roomName = env('JAAS_TENANT_ID') . '/' . $room;
        $this->userName = auth()->user() ? auth()->user()->name : 'Guest';
        $this->email = auth()->user() ? auth()->user()->email : 'guest@example.com';

        $jaasService = new JaaSService();
        $this->token = $jaasService->generateToken($this->roomName, $this->userName, $this->email);
    }

    public function render()
    {
        return view('livewire.jitsi-meeting')
            ->layout('layouts.empty'); // Use an empty layout
    }
}