<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Overrides\HasRoleOverride;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoleOverride;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'username', 'email', 'password', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
