<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RapportetudiantNotifications extends Notification
{
    use Queueable;

    protected $titre;
    protected $lien;

    /**
     * Créer une nouvelle instance de notification.
     */
    public function __construct($titre, $lien)
    {
        $this->titre = $titre;
        $this->lien = $lien;
    }

    /**
     * Canaux de notification.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // mailtrap + stockage DB
    }

    /**
     * Contenu de l’email.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouveau rapport étudiant soumis')
            ->greeting('Bonjour !')
            ->line("Un étudiant vient de soumettre un rapport : **{$this->titre}**")
            ->action('Voir le rapport', $this->lien)
            ->line('Merci d’utiliser notre application.');
    }

    /**
     * Contenu sauvegardé en base.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'titre' => $this->titre,
            'message' => "Un étudiant a soumis un rapport : {$this->titre}",
            'url' => $this->lien,
        ];
    }


    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'lien' => $this->lien ?? '#',
        ];
    }
}
