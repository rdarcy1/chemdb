<?php

namespace App;

class Matchmol {

    protected $output;
    protected $binary = "/usr/local/bin/matchmol";

    protected $queryStructure;
    protected $candidateIds;

    public function __construct($queryStructure, $candidateIds)
    {
        $this->queryStructure = $queryStructure;
        $this->candidateIds = $candidateIds;
    }

    public static function match($queryStructure, $candidateIds)
    {
        return new Matchmol($queryStructure, $candidateIds);   
    }

    public function combineCandidateMolfiles()
    {
        $combinedMolfile[] = preg_replace("/^[A-Z]+\d+.*/", "", $this->queryStructure);

        foreach($this->candidateIds as $candidate) {
            $structure = Structure::find($candidate)->molfile;
            $structure = preg_replace("/^[A-Z]+\d+.*/", "", $structure);
            $combinedMolfile[] = $structure;
        }

        $combinedMolfile = implode($combinedMolfile);
        
        $combinedMolfile = preg_replace('/\$+$/', '', $combinedMolfile);

        $combinedMolfile = str_replace('$', '\$', $combinedMolfile);


        // dd($combinedMolfile);

        $command = 'echo "' . $combinedMolfile . '" | ' . $this->binary . ' -';
        $pipe = popen($command, "r");
        
        while(!feof($pipe)) {
            $this->output .= fread($pipe, 1024);
        }
        pclose($pipe);

        $results = explode("\n", $this->output);
        $results = array_splice($results, 0, -1);

        $resultIds = [];

        foreach($results as $result) {
            $match = explode(":", trim($result));
            if($match[1] == "T") {
                $resultIds[] = $match[0];   
            }
        }

        foreach($resultIds as $resultId) {
            $matchingCandidateIds[] = $this->candidateIds[$resultId-1]; 
        }

        return $matchingCandidateIds;
    }
}
