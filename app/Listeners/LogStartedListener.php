<?php

namespace App\Listeners;

use App\Events\LoggingStarted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogStartedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LoggingStarted $event): void
    {
        Log::info("Начато логирование для модели {$event->model->getTable()} с ID {$event->model->id}. Событие: {$event->event}");
    }
}
