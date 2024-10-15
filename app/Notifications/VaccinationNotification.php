<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VaccinationNotification extends Notification
{
    use Queueable;

    protected $vaccination;

    /**
     * Create a new notification instance.
     */
    public function __construct($vaccination)
    {
        $this->vaccination = $vaccination;
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
            ->greeting('¡Hola, ' . $this->vaccination->pet->owner->first_name . '!')
            ->subject(__('Recordatorio de vacunación para tu mascota.'))
            ->line('La vacuna de tu mascota ' . $this->vaccination->pet->name . ' está por vencer el '. $this->vaccination->next_application)
            ->action('Ver detalles', url('http://127.0.0.1:8000/admin/pets/2/edit'))
            ->line('¡Gracias por usar nuestra aplicación!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
