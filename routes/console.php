<?php

use App\Jobs\ApplyPeriodicTransactionsJob;
use App\Jobs\RollGoalsJob;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new ApplyPeriodicTransactionsJob)
    ->daily()->description('Apply periodic transactions job');

Schedule::job(new RollGoalsJob)->daily()->description('Roll goals job');
