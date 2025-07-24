<?php

namespace App\Policies;

use App\Models\User;

class DoctorProfilePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function editOwnProfile(User $authUser, User $profileUser)
{
    return $authUser->id === $profileUser->id && $authUser->role === 'doctor';
}

}
