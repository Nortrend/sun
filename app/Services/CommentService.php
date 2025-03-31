<?php

namespace App\Services;

use App\Contracts\Commentable;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentService
{

    public static function availableTypes(): array
    {
        $models = [
            Post::class,
            Article::class,
            // новые модели добавишь сюда
        ];

        return collect($models)
            ->filter(fn($model) => in_array(Commentable::class, class_implements($model)))
            ->map(fn($model) => [
                'label' => $model::commentableLabel(),
                'value' => $model
            ])
            ->values()
            ->toArray();
    }
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Создание коммента в таблице
     */
    public function store(array $data): Comment
    {

        $profile = Auth::user()?->profile;

        if (!$profile) {
            throw new \Exception('Профиль пользователя не найден.');
        }

        $data['profile_id'] = $profile->id;

        return Comment::create($data);
    }

    /**
     * Поиск коммента по ID, его обновление и вывод на экран + обработка ошибок
     */
    public function update(int $id, array $data)
    {
        $comment = Comment::find($id);
        if (!$comment) {

            return null;
        }
        $comment->update($data);

        return $comment;
    }

    /**
     * Поиск коммента по ID, его удаление и вывод на экран сообщения об успехе или неудаче
     */
    public function destroy(int $id): bool
    {
        $comment = Comment::find($id);
        if (!$comment) {

            return false;
        }
        $comment->delete();

        return true;
    }

}
