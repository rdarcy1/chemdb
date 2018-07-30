<?php

namespace Tests\Feature;

use App\Structure;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubstructureSearchTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
   function a_substructure_search_can_filter_down_all_candidates_for_the_query()
   {
        // Given we have the three structures in the database
        // chlorobenzene, indole and cyclohexanone
        $chlorobenzene = Structure::storeMolfile(
            file_get_contents("tests/Molfiles/chlorobenzene.mol")
        );

        $indole = Structure::storeMolfile(
            file_get_contents("tests/Molfiles/indole.mol")
        );
        
        $cyclohexanone = Structure::storeMolfile(
            file_get_contents("tests/Molfiles/cyclohexanone.mol")
        );

        // When we search for benzene as a substructure
        $substructureQuery = Structure::fromMolfile(
            file_get_contents("tests/Molfiles/benzene.mol")
        );

        // We expect 2 candidates: chlorobenzene and indole
        $this->assertEquals(2, $substructureQuery->candidates->count());
        $this->assertTrue($substructureQuery->candidates->contains($chlorobenzene));
        $this->assertTrue($substructureQuery->candidates->contains($indole));

        // Assert that cyclohexanone is not a candidate
        $this->assertFalse($substructureQuery->candidates->contains($cyclohexanone));
   }
   
   /** @test */
   function candidates_can_be_filtered_down_to_atom_to_atom_matches()
   {
        // given we the following alcohols in the database:
        // 2-propanol, 1-propanol, 1,3-propanediol
        $isopropanol = Structure::storeMolfile(
            file_get_contents("tests/Molfiles/2-propanol.mol")
        ); 
        // 1-propanol
        $propanol = Structure::storeMolfile(
            file_get_contents("tests/Molfiles/1-propanol.mol")
        ); 
        // 1,3-propanediol
        $propanediol = Structure::storeMolfile(
            file_get_contents("tests/Molfiles/propanediol.mol")
        );

        // And we search for propanol
        $substructureQuery = Structure::fromMolfile(
            file_get_contents("tests/Molfiles/1-propanol.mol")
        );
        
        // when we filter down to the candidates
        // we expect all three matching
        $this->assertEquals(3, $substructureQuery->candidates->count()); 

        $this->assertTrue($substructureQuery->candidates->contains($propanol));
        $this->assertTrue($substructureQuery->candidates->contains($propanediol));
        $this->assertTrue($substructureQuery->candidates->contains($isopropanol));

        // then, when we filter through the exact matches
        // we only expect propanediol and propanol, not isopropanol
        $this->assertEquals(2, $substructureQuery->matches->count()); 

        $this->assertTrue($substructureQuery->matches->contains($propanol));
        $this->assertTrue($substructureQuery->matches->contains($propanediol));
        $this->assertFalse($substructureQuery->matches->contains($isopropanol));

   }
}
