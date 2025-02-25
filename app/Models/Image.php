<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Traits\HasLogs;

class Image extends Model
{
    use HasLogs;
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
