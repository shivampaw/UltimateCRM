<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function client()
    {
    	return $this->belongsTo(Client::class);
    }

    public function invoice()
    {
    	return $this->belongsTo(Invoice::class);
    }
}
