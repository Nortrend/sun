<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DbLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'insert_count',
        'select_count',
        'update_count',
        'delete_count',
        'sql',
        'status',
        'time',
        'message',
    ];

    public function queries()
    {
        return $this->hasMany(DbQuery::class);
    }

}

