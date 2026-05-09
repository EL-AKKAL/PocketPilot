<?php

use App\Jobs\ApplyPeriodicTransactionsJob;

Schedule::job(new ApplyPeriodicTransactionsJob)
    ->dailyAt('05:00');
