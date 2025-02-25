<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {

        // Создаем ровно 10 пользователей
        $users = User::factory(10)->create();

        // Для каждого пользователя создаем профиль
        $users->each(function ($user) {
            Profile::factory()->create(['user_id' => $user->id]);
        });
    }
}
