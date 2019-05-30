<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringInvoice extends Model
{
    protected $fillable = ['client_id', 'item_details', 'discount', 'notes', 'project_id', 'due_date', 'how_often', 'total', 'next_run'];
    protected $dates = ['next_run'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
