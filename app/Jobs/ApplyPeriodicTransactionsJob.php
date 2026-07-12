<?php

namespace App\Jobs;

use App\Models\PeriodicTransaction;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApplyPeriodicTransactionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle(): void
    {
        $today = Carbon::today();

        $periodics = PeriodicTransaction::where('is_active', true)
            ->where('next_apply_date', '<=', $today)
            ->get();

        foreach ($periodics as $periodic) {

            $next = $this->processPeriodic($periodic, $today);

            $periodic->update([
                'next_apply_date' => $next->toDateString(),
                'is_active' => $periodic->end_date
                    ? $next->lte(Carbon::parse($periodic->end_date))
                    : true,
            ]);
        }
    }

    private function processPeriodic(PeriodicTransaction $periodic, Carbon $today): Carbon
    {
        $next = Carbon::parse($periodic->next_apply_date);
        $endDate = $periodic->end_date ? Carbon::parse($periodic->end_date) : null;

        while ($next->lte($today)) {

            if ($endDate && $next->gt($endDate)) {
                break;
            }

            $this->createTransaction($periodic);

            $next = match ($periodic->frequency) {
                'daily' => $next->copy()->addDay(),
                'weekly' => $next->copy()->addWeek(),
                'monthly' => $next->copy()->addMonth(),
                'yearly' => $next->copy()->addYear(),
                default => $next->copy()->addDay(),
            };
        }

        return $next;
    }

    private function createTransaction(PeriodicTransaction $periodic): void
    {
        $periodic->account->transactions()->create([
            'amount' => $periodic->amount,
            'category_id' => $periodic->category_id,
            'description' => $periodic->description,
            'periodic_transaction_id' => $periodic->id,
        ]);
    }
}
