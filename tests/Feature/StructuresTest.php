<?php

namespace Tests\Feature;

use App\Structure;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StructuresTest extends TestCase
{
   use RefreshDatabase;
   
   /** @test */
   function it_can_read_a_molfile_and_get_its_properties()
   {
        $molfile = file_get_contents("tests/Molfiles/chlorobenzene.mol");
        $structure = Structure::fromMolfile($molfile);

        $this->assertEquals(7, $structure->n_atoms);
        $this->assertEquals(7, $structure->n_bonds);
        $this->assertEquals(6, $structure->n_C);
        $this->assertEquals(1, $structure->n_rings);
   }

   /** @test */
   function properties_of_structures_can_be_saved_to_the_database()
   {
        $molfile = file_get_contents("tests/Molfiles/chlorobenzene.mol");
        
        $structure = Structure::fromMolfile($molfile)->save();
        
        $this->assertDatabaseHas('structures', [
            'n_atoms'   => 7,
            'n_bonds'   => 7,
            'n_C'       => 6,
            'n_rings'   => 1
        ]);
   }
}
