<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DoctorNote;
use App\Enums\UserRole;

class DoctorNotePolicy
{
    /**
     * Determine if the given note can be viewed by the user.
     */
    public function view(User $user, DoctorNote $note): bool
    {
        // Doctors can view all notes
        if ($user->role === UserRole::Doctor) {
            return true;
        }

        // Patients can only view their own non-private notes
        return $user->id === $note->user_id && !$note->is_private;
    }

    /**
     * Determine if the user can create notes.
     */
    public function create(User $user): bool
    {
        // Only doctors can create notes
        return $user->role === UserRole::Doctor;
    }

    /**
     * Determine if the given note can be updated by the user.
     */
    public function update(User $user, DoctorNote $note): bool
    {
        // Only the doctor who created the note can update it
        return $user->role === UserRole::Doctor && $user->id === $note->doctor_id;
    }

    /**
     * Determine if the given note can be deleted by the user.
     */
    public function delete(User $user, DoctorNote $note): bool
    {
        // Only the doctor who created the note can delete it
        return $user->role === UserRole::Doctor && $user->id === $note->doctor_id;
    }

    /**
     * Determine if the user can view any notes for a patient.
     */
    public function viewAny(User $user): bool
    {
        // Doctors can view all patient notes
        // Patients can view their own notes
        return $user->role === UserRole::Doctor || $user->role === UserRole::User;
    }
}
