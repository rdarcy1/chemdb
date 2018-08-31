<?php

namespace App\Http\Controllers;

use App\Structure;
use Illuminate\Database\Eloquent\Builder;
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

        $matches = Structure::whereHas('chemical', function (Builder $query) use ($request) {
            $query->where('name', 'like', $request->q);
        })->with('chemical')->orderBy('n_atoms')->get();

        return view('search.substructure.results', compact('matches', 'searchType'));
    }
}
