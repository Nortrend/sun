<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleService
{
    public function __construct()
    {
        //
    }

    /**
     * Создание статьи
     */
    public function store(array $data): Article
    {
        $profile = Auth::user()?->profile;

        if (!$profile) {
            throw new \Exception('Профиль пользователя не найден.');
        }

        $data['profile_id'] = $profile->id;

        return Article::create($data);
    }

    public function update(int $id, array $data)
    {
        $article = Article::find($id);

        if (!$article) {
            return null;
        }

        $article->update($data);
        return $article;
    }

    public function destroy(int $id): bool
    {
        $article = Article::find($id);

        if (!$article) {
            return false;
        }

        $article->delete();
        return true;
    }
}
