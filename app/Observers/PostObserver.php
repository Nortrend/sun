<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{

    public function deleting(Post $post): void
    {
        // Удаляем связи с тегами
        $post->tags()->detach();
        // Удаляем связи с картинками
        $post->image()->delete();
        // Удаляем связи с лайками
        $post->likedBy()->detach();
    }

    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
