<?php

namespace App\Models;

use App\Contracts\Commentable;
use App\Traits\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Traits\HasLogs;
use \App\Models\Log;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model implements Commentable
{
    use HasFactory;

    use HasFilter;
    protected $fillable = [
        'title', 'content', 'profile_id', 'category_id', 'is_published', 'views', 'published_at'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class,'post_tag', 'post_id', 'tag_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function likedBy(): MorphToMany
    {
        return $this->morphToMany(Profile::class, 'likeable');
    }

    public function getLikesCountAttribute(): int
    {
        return $this->likedBy()->count();
    }


    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public static function commentableLabel(): string
    {
        return 'Пост';
    }

}
