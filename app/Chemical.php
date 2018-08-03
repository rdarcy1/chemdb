<?php

namespace App;

use App\User;
use App\Structure;
use Illuminate\Database\Eloquent\Model;


class Chemical extends Model
{
    protected $guarded = [];

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

    public static function syncStructures()
    {
        // Fill in structure_id on Chemical table
        $chemicals = Chemical::all();

        foreach($chemicals as $chemical) {

            $structureId = Structure::where('chemical_id', $chemical->id)->pluck('id');

            if($structureId->count() !== 1) {
                continue;
            }

            $chemical->structure_id = $structureId[0];
            $chemical->save();

        }
    }
}
