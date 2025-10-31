<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorNote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'appointment_id',
        'title',
        'content',
        'category',
        'is_private',
        'follow_up_required',
    ];

    protected $casts = [
        'is_private' => 'boolean',
        'follow_up_required' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the patient this note belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the doctor who created this note.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Get the appointment this note is associated with.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Scope to get only non-private notes (for patient view).
     */
    public function scopeNonPrivate($query)
    {
        return $query->where('is_private', false);
    }

    /**
     * Scope to get notes for a specific patient.
     */
    public function scopeForPatient($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get notes by a specific doctor.
     */
    public function scopeByDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    /**
     * Scope to get notes requiring follow-up.
     */
    public function scopeRequiringFollowUp($query)
    {
        return $query->where('follow_up_required', true);
    }
}
