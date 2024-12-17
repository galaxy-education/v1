<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $appointments = \App\Models\Appointment::where('start_time', '<=', now())
                ->where('end_time', '>=', now())
                ->where('is_booked', true)
                ->get();

            foreach ($appointments as $appointment) {
                event(new \App\Events\SessionStarted($appointment->id));
            }
        })->everyMinute();
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }


}
