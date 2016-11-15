<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
	public function client()
	{
		return $this->belongsTo('App\Client');
	}
}
