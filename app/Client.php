<?php

namespace App;

use App\Invoice;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $fillable = ['full_name', 'email', 'number', 'address', 'stripe_customer_id'];

    public function invoices()
    {
    	return $this->hasMany(Invoice::class);
    }

    public function user()
    {
    	return $this->hasOne(User::class);
    }

    public function addInvoice(Invoice $invoice)
    {
        return $this->invoices()->save($invoice);
    }
    
    protected static function boot() {
        parent::boot();
        static::deleting(function($client) {
            $client->invoices()->delete();
            $client->transactions()->delete();
            User::find($client->user_id)->delete();
        });
    }

}
