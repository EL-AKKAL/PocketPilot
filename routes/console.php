<?php

use App\Jobs\ApplyPeriodicTransactionsJob;
use App\Jobs\RollGoalsJob;

Schedule::job(new ApplyPeriodicTransactionsJob)
    ->dailyAt('00:01');

Schedule::job(new RollGoalsJob)->dailyAt('00:00');
