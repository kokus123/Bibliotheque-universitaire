<?php

namespace App\Notifications;

use App\Models\Borrow;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RetardNotification extends Notification
{
    use Queueable;

    public function __construct(public Borrow $borrow) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $jours = $this->borrow->joursDeRetard();

        return (new MailMessage)
            ->subject('⚠️ Retard de retour - ' . $this->borrow->book->titre)
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line("Vous avez un retard de {$jours} jour(s) pour le retour du livre :")
            ->line('📚 **' . $this->borrow->book->titre . '**')
            ->line('✍️ Auteur : ' . $this->borrow->book->auteur)
            ->line('📅 Date de retour prévue : ' . $this->borrow->date_retour_prevue->format('d/m/Y'))
            ->action('Voir mes emprunts', url('/borrows'))
            ->line('Merci de retourner ce livre dès que possible.')
            ->salutation('La Bibliothèque Universitaire');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'borrow_id'     => $this->borrow->id,
            'book_titre'    => $this->borrow->book->titre,
            'book_auteur'   => $this->borrow->book->auteur,
            'date_prevue'   => $this->borrow->date_retour_prevue->format('d/m/Y'),
            'jours_retard'  => $this->borrow->joursDeRetard(),
            'message'       => "Retard de {$this->borrow->joursDeRetard()} jour(s) pour \"{$this->borrow->book->titre}\"",
        ];
    }
}
