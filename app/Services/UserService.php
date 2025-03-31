<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct()
    {
        //
    }

    /**
     * Создание пользователя
     */
    public function store(array $data): User
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    public function update(int $id, array $data)
    {
        $user = User::find($id);

        if (!$user) {
            return null;
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function destroy(int $id): bool
    {
        $user = User::find($id);

        if (!$user) {
            return false;
        }

        $user->delete();
        return true;
    }
}
