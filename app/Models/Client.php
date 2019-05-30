<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'email', 'number', 'address', 'stripe_customer_id'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function recurringInvoices()
    {
        return $this->hasMany(RecurringInvoice::class, 'client_id');
    }

    public function addInvoice(Invoice $invoice)
    {
        return $this->invoices()->save($invoice);
    }

    public function addProject(Project $project)
    {
        return $this->projects()->save($project);
    }

    public function addRecurringInvoice(RecurringInvoice $recurringInvoice)
    {
        return $this->recurringInvoices()->save($recurringInvoice);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($client) {
            $client->invoices->each->delete();
            $client->projects->each->delete();
            $client->user->delete();
        });
    }
}

