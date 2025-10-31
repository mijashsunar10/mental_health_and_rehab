<?php

namespace App\Http\Controllers;

use App\Models\DoctorNote;
use App\Models\User;
use App\Models\Appointment;
use App\Notifications\DoctorNoteCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DoctorNoteController extends Controller
{
    /**
     * Store a new doctor note.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'is_private' => 'boolean',
            'follow_up_required' => 'boolean',
        ]);

        $note = DoctorNote::create([
            'user_id' => $validated['user_id'],
            'doctor_id' => auth()->id(),
            'appointment_id' => $validated['appointment_id'] ?? null,
            'title' => $validated['title'] ?? null,
            'content' => $validated['content'],
            'category' => $validated['category'] ?? null,
            'is_private' => $validated['is_private'] ?? false,
            'follow_up_required' => $validated['follow_up_required'] ?? false,
        ]);

        // Send notification to patient if note is not private
        if (!$note->is_private) {
            $patient = User::find($validated['user_id']);
            $patient->notify(new DoctorNoteCreatedNotification($note));
        }

        return back()->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified note.
     */
    public function show(DoctorNote $note)
    {
        Gate::authorize('view', $note);

        $note->load(['user', 'doctor', 'appointment']);

        return view('doctor.notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified note.
     */
    public function edit(DoctorNote $note)
    {
        Gate::authorize('update', $note);

        return view('doctor.notes.edit', compact('note'));
    }

    /**
     * Update the specified note.
     */
    public function update(Request $request, DoctorNote $note)
    {
        Gate::authorize('update', $note);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'is_private' => 'boolean',
            'follow_up_required' => 'boolean',
        ]);

        $wasPrivate = $note->is_private;

        $note->update($validated);

        // Send notification if note was private and now made public
        if ($wasPrivate && !$note->is_private) {
            $note->user->notify(new DoctorNoteCreatedNotification($note));
        }

        return back()->with('success', 'Note updated successfully.');
    }

    /**
     * Remove the specified note.
     */
    public function destroy(DoctorNote $note)
    {
        Gate::authorize('delete', $note);

        $note->delete();

        return back()->with('success', 'Note deleted successfully.');
    }

    /**
     * Download a note as PDF.
     */
    public function downloadPdf(DoctorNote $note)
    {
        Gate::authorize('view', $note);

        $note->load(['user', 'doctor', 'appointment']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('doctor.notes.pdf', compact('note'));

        return $pdf->download('note-' . $note->id . '.pdf');
    }
}
