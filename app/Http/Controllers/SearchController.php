<?php

namespace App\Http\Controllers;

use App\Chemical;
use App\Structure;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function index()
    {
        return view('search.home');
    }

    public function substructureSearch(Request $request)
    {
        $queryStructure = Structure::makeFromJSDraw($request->molfile);
        $matchedStructures = $queryStructure->matches;

        $matchingStructureIds = $matchedStructures->map(function($match) {
            return $match->id;
        })->toArray();

        $chemicals = Chemical::whereIn('structure_id', $matchingStructureIds)->get();

        return view('search.substructure.results', compact('chemicals'));
    }
}
