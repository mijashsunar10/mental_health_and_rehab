<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserList extends Component
{
    
    public function render()
        {
            $users = User::where('role', 'user')->get();
            return view('livewire.user-list', [
                "users" => $users,
            ]);
        }

    public function suspend($userId)
    {
        $user = User::find($userId);
        if($user->isSuspended()) {
            $user->unsuspended();
            session()->flash("success","User unsuspended");
        } else {
            $user->suspend();
            session()->flash("success","User suspended");
        }
    }

    public function delete($userId)
    {
        $user = User::find($userId);
        $user->delete();
        session()->flash("success","User deleted successfully");
    }
}