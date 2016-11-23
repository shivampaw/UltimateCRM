<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['item_details', 'due_date', 'paid', 'notes', 'paid_at'];
    protected $dates = ['created_at', 'updated_at', 'paid_at', 'due_date'];
   
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
