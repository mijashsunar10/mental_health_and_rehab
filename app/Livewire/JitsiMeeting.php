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

    public function mount()
    {
        $this->roomName = env('JAAS_TENANT_ID') . '/TestRoom';
        $this->userName = 'John Doe';
        $this->email = 'john.doe@example.com';

        $jaasService = new JaaSService();
        $this->token = $jaasService->generateToken($this->roomName, $this->userName, $this->email);
    }

    public function render()
    {
        return view('livewire.jitsi-meeting');
    }
}
