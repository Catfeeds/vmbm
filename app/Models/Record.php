<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = 'records';

    protected $guarded = [];

    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id');
    }

    public function fan()
    {
        return $this->belongsTo('App\Models\Fan', 'fan_id');
    }
}
