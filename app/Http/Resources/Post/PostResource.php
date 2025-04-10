<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Image\ImageResource;
use App\Http\Resources\Profile\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'content'     => $this->content,
            'image_url'   => $this->image_url,

            // 🔒 Безопасно отдаём image через ресурс
            'image'       => $this->relationLoaded('image') && $this->image
                ? ImageResource::make($this->image)->resolve()
                : null,

            // ✅ Надёжно и просто: сразу массив без "data"
            'category'    => $this->whenLoaded('category', function () {
                return [
                    'id'    => $this->category->id,
                    'title' => $this->category->title,
                ];
            }),

            // ✅ Профиль — используем ресурс, но добавляем защиту
            'profile'     => $this->relationLoaded('profile') && $this->profile
                ? ProfileResource::make($this->profile)->resolve()
                : null,

            // ❤️ Лайки и пользовательские флаги
            'liked'       => $this->likedBy()->where('profile_id', auth()->user()?->profile->id)->exists(),
            'likes_count' => $this->likes_count ?? 0,

            // 🏷️ Теги — как массив сразу
            'tags' => $this->whenLoaded('tags', function () {
                return $this->tags->map(fn($tag) => [
                    'id' => $tag->id,
                    'title' => $tag->title,
                ]);
            }),
        ];
    }
}
