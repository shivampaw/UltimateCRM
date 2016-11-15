<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    public function invoices()
    {
    	return $this->hasMany('App\Invoice');
    }
}
