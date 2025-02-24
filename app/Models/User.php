<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\HasLogs;


class User extends Model
{

    use HasFactory;
    use HasLogs;
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
}
