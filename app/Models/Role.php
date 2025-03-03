<?php

namespace App\Models;

use App\Traits\HasEventLogs;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLogs;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Role extends Model
{
    use HasEventLogs;
//    use HasLogs;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user');
    }



//    protected static function booted()
//    {
//        $events = ['created', 'updated', 'deleted', 'retrieved'];
//
//        foreach ($events as $event) {
//            if (method_exists(static::class, $event . 'Event')) {
//                static::{$event}(fn(Model $model) => null); // Отключаем стандартное логирование, если событие переопределено в модели
//            }
//        }
//    }
//
//    /**
//     * Логирование создания модели
//     */
//    public function createdEvent(): void
//    {
//        $this->logChange('created');
//    }
//
//    /**
//     * Логирование обновления модели
//     */
//    public function updatedEvent(): void
//    {
//        if ($this->wasChanged()) {
//            $this->logChange('updated');
//        }
//    }
//
//    /**
//     * Логирование удаления модели
//     */
//    public function deletedEvent(): void
//    {
//        $this->logChange('deleted');
//    }
//
//    /**
//     * Логирование получения модели
//     */
//    public function retrievedEvent(): void
//    {
//        $this->logChange('retrieved');
//    }
//
//    /**
//     * Универсальный метод логирования
//     */
//    protected function logChange(string $event): void
//    {
//        Log::create([
//            'model' => static::class,
//            'event' => $event,
//            'old_data' => in_array($event, ['updated', 'deleted']) ? json_encode($this->getOriginal()) : null,
//            'new_data' => $event !== 'deleted' ? json_encode($this->getAttributes()) : null,
//            'created_at' => now(),
//            'updated_at' => now(),
//        ]);
//    }

}
