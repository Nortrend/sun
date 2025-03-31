<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Profile\ProfileBriefResource;
use App\Http\Resources\Profile\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'login'         => $this->login,
            'email'         => $this->email,
            'profile'       => new ProfileBriefResource($this->whenLoaded('profile')),
        ];
    }
}
