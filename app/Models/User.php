<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * Returns true if the user is an admin and
     * false if not.
     *
     * @return bool
     */
    public function isAdmin()
    {
        if ($this->is_admin) {
            return true;
        } else {
            return false;
        }
    }

    public function isSuperAdmin()
    {
        if ($this->id === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }
}
