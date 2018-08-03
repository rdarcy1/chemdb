<?php

namespace App\Http\Controllers;

use App\Chemical;
use App\Structure;
use Illuminate\Http\Request;

class ChemicalController extends Controller
{
    public function create()
    {
        return view('chemicals.create');
    }

    public function store(Request $request)
    {
        // Save the structure to the database
        $structure = Structure::createFromJSDraw($request->molfile);

        // Create an svg image of the updated structure
        $structure->generateSVG();

        // Create chemical entry in database
        $chemical = Chemical::create([
            'name'              => $request->name,
            'cas'               => $request->cas,
            'remarks'           => $request->remarks,
            'molecular_weight'  => $request->molweight,
            'density'           => $request->density,
            'structure_id'      => $structure->id,
            'user_id'           => 1
        ]);

        $structure->chemical_id = $chemical->id;
        $structure->save();

        return $chemical;
    }
}
