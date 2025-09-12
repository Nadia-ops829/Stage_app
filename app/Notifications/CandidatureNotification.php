<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Candidature;

class CandidatureNotification extends Notification
{
    use Queueable;

    protected $candidature;
    protected $type; // 'etudiant' ou 'entreprise'

    public function __construct(Candidature $candidature, $type)
    {
        $this->candidature = $candidature;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if ($this->type === 'etudiant') {
            return (new MailMessage)
                ->subject('Réponse à votre candidature')
                ->greeting('Bonjour ' . $this->candidature->etudiant->prenom)
                ->line('Votre candidature pour le stage "' . $this->candidature->stage->titre . '" a été ' . 
                       ($this->candidature->statut === 'acceptee' ? 'acceptée' : 'refusée') . '.')
                ->line('Commentaire de l’entreprise : ' . ($this->candidature->commentaire_entreprise ?? 'Aucun'))
                ->line('Merci pour votre candidature !');
        } else {
            return (new MailMessage)
                ->subject('Nouvelle candidature reçue')
                ->greeting('Bonjour ' . $this->candidature->stage->entreprise->nom)
                ->line('L’étudiant ' . $this->candidature->etudiant->prenom . ' ' . $this->candidature->etudiant->nom .
                       ' a postulé à votre stage : "' . $this->candidature->stage->titre . '".')
                ->line('Merci de vérifier et traiter la candidature.');
        }
    }
}
