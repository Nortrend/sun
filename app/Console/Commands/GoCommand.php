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
    protected $signature = 'go';

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

//        чтение и изменение
//        Role::find(21)->update(['title' => 'newnewnew']);

//        создание
          Profile::create(['name' => 'new name',
              'user_id' => 1,]);

//        удаление
//        Role::destroy(20);

    }
}
