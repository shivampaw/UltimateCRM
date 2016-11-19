<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $dates = ['created_at', 'updated_at', 'accepted_at'];

    public function client()
	{
		return $this->belongsTo(Client::class);
	}
}
