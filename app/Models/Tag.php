<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\HasLogs;


class Tag extends Model
{

    use HasFactory;
//    use HasLogs;
    protected $fillable = ['title'];



    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
