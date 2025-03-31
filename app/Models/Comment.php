<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Traits\HasLogs;

class Comment extends Model
{

    use HasFactory;
//    use HasLogs;
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

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }


}
