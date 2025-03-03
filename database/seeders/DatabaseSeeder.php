<?php

namespace Database\Seeders;

use App\Models\Permission;
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
        $permissions = ['store', 'show', 'update', 'delete'];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['title' => $perm]);
        }

//        $this->call([
//            ProfileSeeder::class,
//            TagSeeder::class,
//            CategorySeeder::class,
//            PostSeeder::class,
//        ]);
    }
}
