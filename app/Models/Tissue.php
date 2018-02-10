<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tissue extends Model
{
    protected $table = 'tissues';

    protected $guarded = [];

    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id');
    }

    public function fan()
    {
        return $this->belongsTo('App\Models\Fan', 'fan_id');
    }

    public function ad()
    {
        return $this->belongsTo('App\Models\AD', 'ad_id');
    }
}
