<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\Profile\ProfileBriefResource;
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
            'id'                    => $this->id,
            'content'               => $this->content,
//            'profile' => new ProfileResource($this->whenLoaded('profile')),
            'profile'               => ProfileResource::make($this->profile)->resolve(),
            'parent_id'             => $this->parent_id,
            'commentable_type'      => $this->commentable_type,
            'commentable_id'        => $this->commentable_id,
            'created_at'            => $this->created_at?->toDateTimeString(),
        ];
    }
}

