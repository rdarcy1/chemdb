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
        $structure = Structure::makeFromMolfile($molfile);

        $this->assertEquals(7, $structure->n_atoms);
        $this->assertEquals(7, $structure->n_bonds);
        $this->assertEquals(6, $structure->n_C);
        $this->assertEquals(1, $structure->n_rings);
   }

   /** @test */
   function properties_of_structures_made_from_molfiles_can_be_saved_to_the_database()
   {
        $molfile = file_get_contents("tests/Molfiles/chlorobenzene.mol");
        
        Structure::makeFromMolfile($molfile)->save();

        $this->assertDatabaseHas('structures', [
            'n_atoms'   => 7,
            'n_bonds'   => 7,
            'n_C'       => 6,
            'n_rings'   => 1
        ]);
   }

   /** @test */
   function it_can_read_a_molfile_from_a_variable_and_get_its_properties()
   {
       $query = "JSDraw207311815072D\r\n
\r\n
  6  6  0  0  0  0              0 V2000\r\n
    7.8800   -6.2000    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\r\n
    6.5290   -5.4200    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\r\n
    6.5290   -3.8600    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\r\n
    9.2310   -5.4200    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\r\n
    9.2310   -3.8600    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\r\n
    7.8800   -3.0800    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\r\n
  1  2  2  0  0  0  0\r\n
  2  3  1  0  0  0  0\r\n
  1  4  1  0  0  0  0\r\n
  4  5  2  0  0  0  0\r\n
  5  6  1  0  0  0  0\r\n
  6  3  2  0  0  0  0\r\n
M  END";

       $structure = Structure::makeFromJSDraw($query);

       $this->assertEquals(6, $structure->n_atoms);
       $this->assertEquals(6, $structure->n_bonds);
       $this->assertEquals(6, $structure->n_C);
       $this->assertEquals(1, $structure->n_rings);
   }

    /** @test */
    function properties_of_structures_made_from_JSDraw_can_be_saved_to_the_database()
    {
        $query = "JSDraw207311815072D\r\n
\r\n
  6  6  0  0  0  0              0 V2000\r\n
    7.8800   -6.2000    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\r\n
    6.5290   -5.4200    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\r\n
    6.5290   -3.8600    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\r\n
    9.2310   -5.4200    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\r\n
    9.2310   -3.8600    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\r\n
    7.8800   -3.0800    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\r\n
  1  2  2  0  0  0  0\r\n
  2  3  1  0  0  0  0\r\n
  1  4  1  0  0  0  0\r\n
  4  5  2  0  0  0  0\r\n
  5  6  1  0  0  0  0\r\n
  6  3  2  0  0  0  0\r\n
M  END";


        Structure::makeFromJSDraw($query)->save();

        $this->assertDatabaseHas('structures', [
            'n_atoms'   => 6,
            'n_bonds'   => 6,
            'n_C'       => 6,
            'n_rings'   => 1
        ]);
    }
    
    /** @test */
    function a_structure_saves_its_SVG_data_in_the_database()
    {
        // When we add a new structure to the database
        $structure = Structure::createFromMolfile(
            file_get_contents("tests/Molfiles/1-propanol.mol")
        );

        // And then generate the SVG for this structure
        $structure->generateSVG();

        // We expect the SVG to be saved
        $path = 'public/molfiles/svg';
        $this->assertFileExists($path . '/' . $structure->id . '.svg');

        unlink($path . '/' . $structure->id . '.svg');
    }
}
