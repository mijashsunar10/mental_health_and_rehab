<?php

namespace App\Notifications;

use App\Models\DoctorNote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DoctorNoteCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public DoctorNote $note
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Note Added to Your Medical Records')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Dr. ' . $this->note->doctor->name . ' has added a new note to your medical records.')
            ->when($this->note->title, function ($mail) {
                return $mail->line('**Note Title:** ' . $this->note->title);
            })
            ->when($this->note->category, function ($mail) {
                return $mail->line('**Category:** ' . $this->note->category);
            })
            ->line('You can view this note and your complete medical records by clicking the button below.')
            ->action('View My Records', route('records.index'))
            ->line('Thank you for choosing our mental health services.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'note_id' => $this->note->id,
            'doctor_id' => $this->note->doctor_id,
            'doctor_name' => $this->note->doctor->name,
            'title' => $this->note->title,
            'category' => $this->note->category,
            'created_at' => $this->note->created_at,
        ];
    }
}
