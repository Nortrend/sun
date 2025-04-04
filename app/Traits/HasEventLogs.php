<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait HasEventLogs
{

    /**
     * Этот метод автоматически вызывается при загрузке трейта в модель.
     * Он регистрирует обработчики событий модели.
     */
    protected static function bootHasEventLogs()
    {
        static::created(fn(Model $model) => $model->logEvent('created'));
        static::updated(fn(Model $model) => $model->logEvent('updated'));
        static::retrieved(fn(Model $model) => $model->logEvent('retrieved'));
        static::deleted(fn(Model $model) => $model->logEvent('deleted'));
    }

    /**
     * Метод логирования событий модели.
     * @param string $event Тип события (created, updated, retrieved, deleted)
     */
    protected function logEvent(string $event): void
    {
        $logEntry = match ($event) {
            'created' => ['data' => $this->getAttributes()],
            'updated' => ['changed' => $this->getChangedAttributes()],
            'retrieved', 'deleted' => ['id' => $this->id],
            default => [],
        };

        // Вызываем метод для записи лога в файл
        $this->writeToLog(class_basename($this), $event, $logEntry);
    }

    /**
     * Метод для получения измененных атрибутов модели при обновлении.
     * @return array Ассоциативный массив с измененными полями (ключ: имя поля, значение: старое и новое значение).
     */
    protected function getChangedAttributes(): array
    {
        return collect($this->getChanges())
            ->map(fn($value, $key) => ['old' => $this->getOriginal($key), 'new' => $value])
            ->toArray();
    }

    /**
     * Запись логов в файлы.
     * @param string $model Название модели (например, Post, User)
     * @param string $event Тип события (created, updated, retrieved, deleted)
     * @param array $data Данные для записи
     */
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

        // Записываем данные в лог-файл (добавляем в конец файла)
        File::append($logFile, $logEntry);
    }

}
