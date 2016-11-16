<?php

namespace App;

use App\Invoice;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $fillable = ['full_name', 'email', 'number', 'address'];
    //
    public function invoices()
    {
    	return $this->hasMany(Invoice::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
    	return $this->hasOne(User::class);
    }

    public function addInvoice(Invoice $invoice)
    {
        return $this->invoices()->save($invoice);
    }

}
