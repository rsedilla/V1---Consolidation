<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberDeletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected array $memberData;
    protected array $deletionResult;
    protected string $deletedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $memberData, array $deletionResult, string $deletedBy)
    {
        $this->memberData = $memberData;
        $this->deletionResult = $deletionResult;
        $this->deletedBy = $deletedBy;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Member Deleted - ' . $this->memberData['name'])
                    ->greeting('Member Deletion Alert')
                    ->line('A member has been deleted from the system.')
                    ->line('**Member Details:**')
                    ->line('Name: ' . $this->memberData['name'])
                    ->line('Email: ' . $this->memberData['email'])
                    ->line('Type: ' . ($this->memberData['member_type'] ?? 'N/A'))
                    ->line('**Deletion Details:**')
                    ->line('Deleted by: ' . $this->deletedBy)
                    ->line('Consolidator dependents reassigned: ' . $this->deletionResult['reassigned_consolidator_dependents'])
                    ->line('G12 dependents affected: ' . $this->deletionResult['reassigned_g12_dependents'])
                    ->line('**Note:** This is a PERMANENT deletion. The record cannot be recovered.')
                    ->action('View Admin Panel', url('/admin'))
                    ->line('This is an automated notification for audit purposes.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'member_data' => $this->memberData,
            'deletion_result' => $this->deletionResult,
            'deleted_by' => $this->deletedBy,
        ];
    }
}