<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\SendEmailsFromContactUs;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// protected function schedule(Schedule $schedule)
// {
//     $schedule->command('emails:send-contact-us')
//              ->everyFiveMinutes();
// }
Schedule::command(SendEmailsFromContactUs::class)->everyMinute();


// return function (Schedule $schedule) {
//     $schedule->command('appointments:notify')->everyFifteenSeconds();
// };


