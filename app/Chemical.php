<?php

namespace App;

use App\User;
use App\Structure;
use Illuminate\Database\Eloquent\Model;


class Chemical extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function bottles()
    {
        return $this->hasMany(Bottle::class);
    }
}
