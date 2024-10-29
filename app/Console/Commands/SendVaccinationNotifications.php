<?php

namespace App\Console\Commands;

use App\Models\Vaccination;
use App\Notifications\VaccinationNotification;
use Illuminate\Console\Command;

class SendVaccinationNotifications extends Command
{
    /**
     * El nombre y la firma del comando de consola..
     *
     * @var string
     */
    protected $signature = 'send:vaccination-notifications';

    /**
     * Descripción del comando de consola.
     *
     * @var string
     */
    protected $description = 'Sends vaccination reminders to pet owners';

    /**
     * Ejecutar el comando de consola.
     */
    public function handle()
    {
        // Obtener las vacunaciones cuya próxima aplicación sea en los próximos 3 días
        $vaccinations = Vaccination::where('next_application', '<=', now()->addDays(3))->get();

        foreach ($vaccinations as $vaccination) {
            // Obtener el dueño de la mascota que recibió la vacunación
            $owner = $vaccination->pet->owner;

            // Enviar una notificación al dueño sobre la vacunación realizada
            $owner->notify(new VaccinationNotification($vaccination));
        }
    }
}
