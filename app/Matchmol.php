<?php

namespace App;

class Matchmol {

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

    public function substructure()
    {
        $matchResults = BashCommand::run($this->buildQuery(), $this->binary, '-');
        $resultsArray = $this->generateResultsArray($matchResults);

        return $this->filterMatchingCanidateIds($resultsArray);
    }

    public function exact()
    {
        $matchResults = BashCommand::run($this->buildQuery(), $this->binary, '-x -');

        $resultsArray = $this->generateResultsArray($matchResults);

        return $this->filterMatchingCanidateIds($resultsArray);
    }

    protected function buildQuery()
    {
        $molfilesArray[] = $this->trimFormula($this->queryStructure);

        foreach ($this->candidateIds as $candidate) {
            $molfilesArray[] = $this->trimFormula(
                Structure::find($candidate)->molfile
            );
        }

        $formattedQuery = $this->formatQuery($molfilesArray);

        return $formattedQuery;
    }

    protected function trimFormula($molfile)
    {
        return preg_replace("/^[A-Z]+\d+.*/", "", $molfile);
    }

    protected function formatQuery($molfilesArray) {

        // remove all present '$$$$' separators
        foreach ($molfilesArray as $molfile) {
            $strippedMolfileArray[] = preg_replace('/\$+/', '', $molfile);
        }

        $molfileString = implode($strippedMolfileArray, "\n $$$$ \n");
        $molfileString = preg_replace('/\$+$/', '', $molfileString);

        return str_replace('$', '\$', $molfileString);
    }

    protected function generateResultsArray($matchResults)
    {
        $resultsArray = explode("\n", $matchResults);
        return array_splice($resultsArray, 0, -1);
    }

    protected function filterMatchingCanidateIds(array $resultsArray)
    {
        $resultIds = [];

        foreach($resultsArray as $result) {
            $match = explode(":", trim($result));
            if($match[1] == "T") {
                $resultIds[] = $match[0];
            }
        }

        $matchingCandidateIds = [];

        foreach($resultIds as $resultId) {
            $matchingCandidateIds[] = $this->candidateIds[$resultId-1];
        }

        return $matchingCandidateIds;
    }
}
