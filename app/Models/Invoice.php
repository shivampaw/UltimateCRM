<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['item_details', 'due_date', 'paid', 'notes', 'paid_at', 'discount', 'total', 'overdue_notification_sent'];
    protected $dates = ['created_at', 'updated_at', 'paid_at', 'due_date'];

//    protected $with = ['client'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function markAsPaid($stripeChargeId)
    {
        $this->stripe_charge_id = $stripeChargeId;
        $this->paid = true;
        $this->paid_at = Carbon::now();
        $this->save();
    }
}
