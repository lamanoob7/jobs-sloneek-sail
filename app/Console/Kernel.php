<?php

namespace App\Console;

use App\Jobs\SendArticlesToSubscribers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function commands(): void
    {
        $this->load(__DIR__);
    }


    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new SendArticlesToSubscribers())->twiceDaily(11, 17);
    }

}
