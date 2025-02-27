<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\LoggingStarted;
use App\Events\LoggingCompleted;
use App\Listeners\LogStartedListener;
use App\Listeners\LogCompletedListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Сопоставляем события и слушатели.
     */
    protected $listen = [
        LoggingStarted::class => [
            LogStartedListener::class,
        ],
        LoggingCompleted::class => [
            LogCompletedListener::class,
        ],
    ];

    /**
     * Регистрация любых событий.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
