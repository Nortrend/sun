<?php

namespace App\Http\Resources\Profile;

use App\Http\Resources\User\UserBriefResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'user'      => new UserBriefResource($this->whenLoaded('user')),
        ];
    }
}
