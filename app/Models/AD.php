<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AD extends Model
{
    protected $table = 'ads';

    protected $guarded = [];

    public function tissue()
    {
        $this->hasMany('App\Models\Tissue', 'ad_id');
    }
}
