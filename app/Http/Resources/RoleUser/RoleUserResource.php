<?php

namespace App\Http\Resources\RoleUser;

use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\User\UserBriefResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'user' => new UserBriefResource($this->user),
            'role' => new RoleResource($this->role),
        ];
    }
}
