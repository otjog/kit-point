<?php

namespace App\Console;

use App\Models\Site\Mailling;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\Price\CurrencyController;
use App\Events\MaillingForRegister;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*Обновляем Курсы Валют*/
        $schedule->call(function ()
        {
            $cur = New CurrencyController();

            $cur->getCur();

        })->daily();

        /*Отправка рассылок клиентам*/
        $schedule->call(function ()
        {
            $maillingModel = new Mailling();

            $maillings = $maillingModel->getActiveMaillings();

            $roundToHour = 3600;
            $roundToMinute = 60;

            $roundTo = $roundToHour;

            /**
             * Мы округляем timestamp, до 1 часа. Т.е любое время указанное в пределах одного
             * округлится по математическим законам в к ближайщему часу.
             */
            $timestampNow = round((time())/$roundTo)*$roundTo;

            $today = date('N');

            foreach ($maillings as $mailling) {

                if ($today === $mailling->dayOfWeek) {

                    $timestampEvent = round( $mailling->timestamp/$roundTo)*$roundTo;

                    if ($timestampNow === $timestampEvent) {
                        event(new MaillingForRegister($mailling));
                    }
                }

            }

        })->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
