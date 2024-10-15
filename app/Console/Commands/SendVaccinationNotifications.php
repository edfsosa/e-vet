<?php

namespace App\Console\Commands;

use App\Models\Vaccination;
use App\Notifications\VaccinationNotification;
use Illuminate\Console\Command;

class SendVaccinationNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:vaccination-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends vaccination reminders to pet owners';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtener las vacunaciones cuya próxima aplicación sea en los próximos 3 días
        $vaccinations = Vaccination::where('next_application', '<=', now()->addDays(3))->get();

        foreach ($vaccinations as $vaccination) {
            $owner = $vaccination->pet->owner;

            // Enviar el correo
            $owner->notify(new VaccinationNotification($vaccination));
        }
    }
}
