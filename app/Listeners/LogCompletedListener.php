<?php

namespace App\Listeners;

use App\Events\LoggingCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogCompletedListener
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
    public function handle(LoggingCompleted $event): void
    {
        Log::info("Завершено логирование для модели {$event->model->getTable()} с ID {$event->model->id}. Событие: {$event->event}");
    }
}
