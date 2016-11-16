<?php

namespace App;

use App\Transaction;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['item_details', 'due_date', 'paid', 'notes'];
    
    //
	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function transaction()
	{
		return $this->hasOne(Transaction::class);	
	}

	public function addTransaction(Transaction $transaction)
	{
		return $this->transaction()->save($transaction);
	}
}
