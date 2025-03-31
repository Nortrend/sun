<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\Profile\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'profile'       => ProfileResource::make($this->profile)->resolve(),
        ];
    }
}
