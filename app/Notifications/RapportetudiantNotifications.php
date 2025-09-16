<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RapportetudiantNotifications extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $lien;
    protected $type; // 'nouveau', 'validation', 'refus', etc.

    /**
     * Créer une nouvelle instance de notification.
     */
    public function __construct($message, $lien = null, $type = 'info')
    {
        $this->message = $message;
        $this->lien = $lien;
        $this->type = $type;
    }

    /**
     * Canaux de notification.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Obtenir la représentation par e-mail de la notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage);
        
        // Personnaliser le sujet en fonction du type de notification
        switch ($this->type) {
            case 'nouveau':
                $mailMessage->subject('Nouveau rapport de stage déposé');
                $mailMessage->greeting('Bonjour !');
                $mailMessage->line($this->message);
                if ($this->lien) {
                    $mailMessage->action('Voir le rapport', $this->lien);
                }
                break;
                
            case 'validation':
                $mailMessage->subject('Votre rapport a été validé');
                $mailMessage->greeting('Bonjour !');
                $mailMessage->line($this->message);
                if ($this->lien) {
                    $mailMessage->action('Voir le rapport', $this->lien);
                }
                break;
                
            case 'refus':
                $mailMessage->subject('Votre rapport nécessite des modifications');
                $mailMessage->greeting('Bonjour,');
                $mailMessage->line($this->message);
                if ($this->lien) {
                    $mailMessage->action('Voir les détails', $this->lien);
                }
                $mailMessage->line('Veuillez apporter les modifications demandées et soumettre à nouveau votre rapport.');
                break;
                
            default:
                $mailMessage->subject('Notification concernant votre rapport de stage');
                $mailMessage->line($this->message);
                if ($this->lien) {
                    $mailMessage->action('Voir les détails', $this->lien);
                }
        }
        
        $mailMessage->line('Cordialement,')
                   ->salutation("L'équipe " . config('app.name'));
        
        return $mailMessage;
    }

    /**
     * Obtenir la représentation tableau de la notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'lien' => $this->lien,
            'type' => $this->type,
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'lien' => $this->lien,
            'type' => $this->type,
            'time' => now()->toDateTimeString(),
        ];
    }
}
