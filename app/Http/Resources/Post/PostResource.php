<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Определение того, какие данные нужно выводить
     */
    public function toArray(Request $request): array
    {

        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'content'       => $this->content,
            'likes_count'   => $this->likes_count ?? 0, // 🔥 Добавляем `?? 0`, чтобы не было null
        ];
    }
}
