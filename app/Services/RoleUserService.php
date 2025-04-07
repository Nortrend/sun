<?php

namespace App\Services;

use App\Models\RoleUser;

class RoleUserService
{
    public function store(array $data): RoleUser
    {
        return RoleUser::create($data);
    }
}
