<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringInvoice extends Model
{
    protected $fillable = ['invoice_id', 'next_run', 'last_run', 'due_date', 'how_often', 'client_id'];
    protected $dates = ['created_at', 'updated_at', 'next_run', 'last_run'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
