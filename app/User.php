<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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
     * false if not
     *
     * @return boolean
     */
    public function isAdmin()
    {
        if($this->is_admin === 1){
            return true;
        }else{
            return false;
        }
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }
}
