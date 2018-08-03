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
        $searchType = 'substructure';

        $queryStructure = Structure::makeFromJSDraw($request->molfile);
        $matches = $queryStructure->matches;

        return view('search.substructure.results', compact('matches', 'searchType'));
    }

    public function textSearch(Request $request)
    {
        $searchType = 'text';

        $matches = Chemical::where('name', 'like', $request->q)->pluck('structure_id');
        $matches = Structure::whereIn('id', $matches)->with('chemical')->orderBy('n_atoms')->get();

        return view('search.substructure.results', compact('matches', 'searchType'));
    }
}
