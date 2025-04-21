<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\Profile\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'content'     => $this->content,

            // Только если profile загружен — экономия на запросах
            'profile'     => $this->whenLoaded('profile', fn () => ProfileResource::make($this->profile)),

            'parent_id'   => $this->parent_id,

            // Показываем родителя, только если он загружен
            'parent'      => $this->whenLoaded('parent', fn () => CommentResource::make($this->parent)),
            'children'    => CommentResource::collection($this->whenLoaded('children')),

            // Показываем информацию о связи commentable, если нужно
            'commentable' => [
                'type'    => class_basename($this->commentable_type),
                'id'      => $this->commentable_id,
            ],

            'created_at'  => $this->created_at?->toDateTimeString(),
            'published_date' => $this->published_date,
        ];
    }
}
