<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Traits\HasLogs;
use \App\Models\Log;

class Post extends Model
{

    use HasFactory;
    use HasLogs;

    /**
     * Если модель переопределяет события, логирование выполняется только там.
     */
    protected static function booted()
    {
        $events = ['created', 'updated', 'deleted', 'retrieved'];

        foreach ($events as $event) {
            if (method_exists(static::class, $event . 'Event')) {
                static::{$event}(fn(Model $model) => null); // Отключаем стандартное логирование, если событие переопределено в модели
            }
        }
    }

    /**
     * Логирование создания модели
     */
    public function createdEvent(): void
    {
        $this->logChange('created');
    }

    /**
     * Логирование обновления модели
     */
    public function updatedEvent(): void
    {
        if ($this->wasChanged()) {
            $this->logChange('updated');
        }
    }

    /**
     * Логирование удаления модели
     */
    public function deletedEvent(): void
    {
        $this->logChange('deleted');
    }

    /**
     * Логирование получения модели
     */
    public function retrievedEvent(): void
    {
        $this->logChange('retrieved');
    }

    /**
     * Универсальный метод логирования
     */
    protected function logChange(string $event): void
    {
        Log::create([
            'model' => static::class,
            'event' => $event,
            'old_data' => $event === 'updated' ? json_encode($this->getOriginal()) : null,
            'new_data' => json_encode($this->getAttributes()),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class,'post_tag', 'post_id', 'tag_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function likedBy(): MorphToMany
    {
        return $this->morphToMany(Profile::class, 'likeable');
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
