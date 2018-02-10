<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function tissue()
    {
        return $this->hasMany('App\Models\Tissue', 'device_id');
    }
}
