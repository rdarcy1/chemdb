<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bottle extends Model
{
    protected $guarded = [];

    public function chemical()
    {
        return $this->belongsTo(Chemical::class);
    }
}
