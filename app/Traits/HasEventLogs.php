<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait HasEventLogs
{
    protected static function bootHasEventLogs()
    {
        static::created(fn(Model $model) => $model->logEvent('created'));
        static::updated(fn(Model $model) => $model->logEvent('updated'));
        static::retrieved(fn(Model $model) => $model->logEvent('retrieved'));
        static::deleted(fn(Model $model) => $model->logEvent('deleted'));
    }

    protected function logEvent(string $event): void
    {
        $logEntry = match ($event) {
            'created' => ['data' => $this->getAttributes()],
            'updated' => ['changed' => $this->getChangedAttributes()],
            'retrieved', 'deleted' => ['id' => $this->id],
            default => [],
        };

        // Передаем три аргумента
        $this->writeToLog(class_basename($this), $event, $logEntry);
    }

    protected function getChangedAttributes(): array
    {
        return collect($this->getChanges())
            ->map(fn($value, $key) => ['old' => $this->getOriginal($key), 'new' => $value])
            ->toArray();
    }

    protected function writeToLog(string $model, string $event, array $data): void
    {
        $directoryPath = storage_path("logs/{$model}");
        $filePath = "{$directoryPath}/{$event}.log";

        // Принудительно создаем директорию, если её нет
        $logPath = storage_path("logs/{$model}");
        if (!File::exists($logPath)) {
            File::makeDirectory($logPath);
        }

        // Формируем строку лога
        $logFile = "{$logPath}/{$event}.log";
        $timestamp = now()->format('Y-m-d H:i:s');
        $logEntry = "{$timestamp} | Data: " . json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL;

        // Записываем в файл
        File::append($logFile, $logEntry);
    }

}
