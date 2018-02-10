<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fan extends Model
{
    protected $table = 'fans';

    protected $guarded = [];

    public function tissue()
    {
        $this->hasMany('App\Models\Tissue', 'fan_id');
    }
}
