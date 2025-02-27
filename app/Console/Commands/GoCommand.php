<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class GoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:go-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

//        // чтение
//        $role = Role::find(2);
//
//        // изменение
//        $role->update(['title' => 'new updated title']);

//        //создание
//             Role::create([
//            'title' => '3d Role Title',
//        ]);

//        удаление
        $role = Role::find(3);
        $role->delete();

    }
}
