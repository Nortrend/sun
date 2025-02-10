<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Comment extends Model
{
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function childrenComments(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    public function parentComments(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->post->category();
    }
}
