<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Image\ImageResource;
use App\Http\Resources\Profile\ProfileResource;
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
            'liked'         => $this->likedBy()->where('profile_id', auth()->user()?->profile->id)->exists(),
            'id'            => $this->id,
            'title'         => $this->title,
            'content'       => $this->content,
            'image'         => ImageResource::make($this->whenLoaded('image')),
            'image_url'     => $this->image_url,
//            'category_id'   => CategoryResource::make($this->whenLoaded('category')),
            'likes_count'   => $this->likes_count ?? 0, // 🔥 Добавляем `?? 0`, чтобы не было null
            'profile'       => ProfileResource::make($this->profile)->resolve(),
        ];
    }
}

