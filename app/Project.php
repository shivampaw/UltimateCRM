<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $dates = ['created_at', 'updated_at', 'accepted_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }


    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($project) {
            $project->invoices()->delete();
        });
    }
}
