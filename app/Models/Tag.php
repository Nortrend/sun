<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\HasLogs;


class Tag extends Model
{

    use HasFactory;
    use HasLogs;



    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
