<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $fillable = ['full_name', 'email', 'number', 'address'];
    //
    public function invoices()
    {
    	return $this->hasMany('App\Invoice');
    }

    public function user()
    {
    	return $this->hasOne('App\User');
    }

}
