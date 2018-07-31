<?php

namespace App;

use App\Checkmol;
use App\Matchmol;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    protected $guarded = [];

    public static function fromMolfile($molfile) {
        return self::make(
            Checkmol::propertiesFor($molfile)
        );
    }

    public static function storeMolfile($molfile) {
        return self::create(
            Checkmol::propertiesFor($molfile)
        );
    }

    public function getCandidatesAttribute()
    {
        return $this->getCandidates();
    }

    public function getMatchesAttribute()
    {
        $queryStructure = $this->molfile;
        
        $candidateIds = $this->getCandidates()->map(function($candidate) {
            return $candidate->id;
        });

        $matchingStructureIds = Matchmol::match($queryStructure, $candidateIds)->substructure();

        return Structure::find($matchingStructureIds);
    }

    public function getExactMatchesAttribute()
    {
        $queryStructure = $this->molfile;

        $candidateIds = $this->getCandidates()->map(function($candidate) {
            return $candidate->id;
        });

        $matchingStructureIds = Matchmol::match($queryStructure, $candidateIds)->exact();

        return Structure::find($matchingStructureIds);
    }

    public function getCandidates()
    {
        foreach($this->toArray() as $key => $value) {
            if($key !== 'molfile') {
                $query[] = [$key, '>=', $value];
            }
        }

        return self::where($query)->get();
    }
}
