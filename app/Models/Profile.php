<?php

namespace App\Models;

use App\Traits\HasEventLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Traits\HasLogs;

class Profile extends Model
{

    use HasFactory;
//    use HasLogs;
    use HasEventLogs;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function likedPosts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'likeable');
    }

    public function likedComments(): MorphToMany
    {
        return $this->morphedByMany(Comment::class, 'likeable');
    }
}
