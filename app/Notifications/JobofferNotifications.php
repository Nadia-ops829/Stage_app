<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobofferNotifications extends Notification
{
    use Queueable;

    protected $jobTitle;

    /**
     * Create a new notification instance.
     */
    public function __construct($jobTitle = null)
    {
        $this->jobTitle = $jobTitle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail']; // Ici tu peux ajouter 'database' si tu veux stocker aussi
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle offre de stage disponible')
            ->greeting('Bonjour !')
            ->line('Une nouvelle offre de stage a été publiée :')
            ->line($this->jobTitle ?? 'Titre de l’offre non spécifié')
            ->action('Voir l’offre', url('/stages'))
            ->line('Merci d’utiliser notre application.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'job_title' => $this->jobTitle,
        ];
    }
}
