<?php

namespace App;

use App\Checkmol;
use App\Matchmol;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    protected $guarded = [];

    public function chemical()
    {
        return $this->belongsTo(Chemical::class);
    }

    public static function makeFromMolfile($molfile) {
        return self::make(
            Checkmol::propertiesFor($molfile)
        );
    }

    public static function createFromMolfile($molfile) {
        return self::create(
            Checkmol::propertiesFor($molfile)
        );
    }

    public static function makeFromJSDraw($query)
    {
        $query = preg_replace('/^\\n/m', '', $query);
        $query = "\r\n" . "$query";

        return self::make(
            Checkmol::propertiesFor($query)
        );
    }

    public static function createFromJSDraw($query)
    {
        $query = preg_replace('/^\\n/m', '', $query);
        $query = "\r\n" . "$query";

        return self::create(
            Checkmol::propertiesFor($query)
        );
    }

    public function generateSVG()
    {
        Mol2SVG::create($this->molfile, $this->id);
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

        $matchingStructures = Structure::with('chemical')
            ->whereIn('id', $matchingStructureIds)
            ->orderBy('n_atoms', 'ASC')
            ->get();

        return $matchingStructures;
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

    public static function import($directory = 'import-molfiles')
    {
        $files = scandir($directory);

        foreach($files as $filename) {
            if($filename[0] == '.' || $filename[0] == '..') {
                continue;
            }

            $path = $directory . '/' . $filename;

            $molfile = file_get_contents($path);

            preg_match('/(\d+)\.mol/', $filename, $matches);

            $id = $matches[1];

            Structure::where('chemical_id', $id)->update(['molfile' => $molfile]);

        }

        return 'finished';
    }

    public static function syncChemicals() {
        $structures = Structure::all();

        foreach($structures as $structure) {
            if(!$chemical = Chemical::find($structure->chemical_id)) {
                continue;
            }

            $chemical->structure_id = $structure->id;
            $chemical->save();
        }
    }

    public static function purge() {
        // delete all structures of which the chemical does not exist
        $structures = Structure::all();

        foreach($structures as $structure) {
            echo 'running structure id ' . $structure->id;

            if ( ! $chemical = Chemical::find($structure->chemical_id)) {
                // if the chemical is not found, let's delete the structure
                echo 'deleted ' . $structure->id;
                echo '\n';

                $structure->delete();
            }
        }
    }
}
