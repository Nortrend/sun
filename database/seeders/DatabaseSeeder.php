<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

//        $user = [
//            'login' => 'user',
//            'email' => 'user@example.com',
//            'password' => Hash::make(123123123),
//        ];
//
//        $user = User::firstOrCreate([
//            'email' => $user['email'],
//        ],$user);
//
//        $user->profile()->create();

        $this->call([
            ProfileSeeder::class,
            TagSeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
        ]);
    }
}
