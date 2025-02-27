<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

trait HasLogs
{
    /**
     * Автоматическое логирование событий модели
     */
    protected static function bootHasLogs(): void
    {
        static::registerEvent('created');
        static::registerEvent('updated');
        static::registerEvent('deleted');
        static::registerEvent('retrieved');
    }

    /**
     * Регистрация событий модели
     */
    protected static function registerEvent(string $event): void
    {
        static::$event(function (Model $model) use ($event) {
            // Если в модели определен метод {event}Event(), используем его
            $method = $event . 'Event';
            if (method_exists($model, $method)) {
                return $model->{$method}();
            }

            // В противном случае используем стандартное логирование
            $model->logEvent($event);
        });
    }

    /**
     * Логирование события модели в таблицу logs
     */
    protected function logEvent(string $event): void
    {
        try {
            DB::table('logs')->insert([
                'model' => get_class($this),
                'event' => $event,
                'old_data' => in_array($event, ['updated', 'deleted']) ? json_encode($this->getOriginal()) : null,
                'new_data' => $event !== 'deleted' ? json_encode($this->getAttributes()) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error("Ошибка логирования для " . get_class($this) . ": " . $e->getMessage());
        }
    }
}
