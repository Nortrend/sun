<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DbQuery extends Model
{
    use HasFactory;

    protected $fillable = ['db_log_id', 'sql'];

    public function dbLog()
    {
        return $this->belongsTo(DbLog::class);
    }
}

