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
    protected static function booted(): void
    {
        static::created(fn(Model $model) => $model->logEvent('created'));
        static::updated(fn(Model $model) => $model->logEvent('updated'));
        static::deleted(fn(Model $model) => $model->logEvent('deleted'));
        static::retrieved(fn(Model $model) => $model->logEvent('retrieved'));
    }

    /**
     * Логирование события модели в БД
     */
    protected function logEvent(string $event): void
    {
        try {
            DB::table('logs')->insert([
                'model' => get_class($this),
                'event' => $event,
                'old_data' => $event === 'updated' ? json_encode($this->getOriginal()) : null,
                'new_data' => json_encode($this->getAttributes()),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error("Ошибка логирования для " . get_class($this) . ": " . $e->getMessage());
        }
    }
}
