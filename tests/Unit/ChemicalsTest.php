<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChemicalsTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function it_has_a_name()
    {
        $chemical = factory('App\Chemical')->create(['name' => 'Some chemical']);

        $this->assertEquals('Some chemical', $chemical->name);
    }

    /** @test **/
    public function it_has_a_CAS_number()
    {
        $chemical = factory('App\Chemical')->create(['cas' => '10-2-111']);

        $this->assertEquals('10-2-111', $chemical->cas);
    }

    /** @test **/
    public function it_has_a_location()
    {
       $chemical = factory('App\Chemical')->create(['location' => 'Fake lab I']);

        $this->assertEquals('Fake lab I', $chemical->location);
    }

    /** @test **/
    public function it_has_a_number()
    {
       $chemical = factory('App\Chemical')->create(['number' => 3]);

        $this->assertEquals(3, $chemical->number);
    }

    /** @test **/
    public function it_has_a_quantity()
    {
       $chemical = factory('App\Chemical')->create(['quantity' => '50 mL']);

        $this->assertEquals('50 mL', $chemical->quantity);
    }

     /** @test **/
    public function it_has_a_supplier()
    {
       $chemical = factory('App\Chemical')->create(['supplier' => 'Sigma Aldrich']);

        $this->assertEquals('Sigma Aldrich', $chemical->supplier);
    }

     /** @test **/
    public function it_has_a_purity()
    {
       $chemical = factory('App\Chemical')->create(['purity' => '99%']);

        $this->assertEquals('99%', $chemical->purity);
    }

    /** @test **/
    public function it_has_a_molecular_weight()
    {
        $chemical = factory('App\Chemical')->create(['molecular_weight' => 123.45]);
        
        $this->assertEquals(123.45, $chemical->molecular_weight);
    }

    /** @test **/
    public function it_has_a_density()
    {
        $chemical = factory('App\Chemical')->create(['density' => 0.965]);

        $this->assertEquals(0.965, $chemical->density);
    }

     /** @test **/
    public function it_has_remarks()
    {
        $chemical = factory('App\Chemical')->create(['remarks' => 'This is a fake remark']);

        $this->assertEquals('This is a fake remark', $chemical->remarks);
    }

    /** @test **/
    public function it_belongs_to_a_user()
    {
        $user = factory('App\User')->create(['id' => 999, 'name' => 'John']);

        $chemical = factory('App\Chemical')->create(['user_id' => $user->id]);

        $this->assertEquals(999, $chemical->user->id);
        $this->assertEquals('John', $chemical->user->name);
    }

    /** @test **/
    public function it_has_a_structure()
    {
        $structure = factory('App\Structure')->create(['id' => 999, 'n_C' => 10]);
        $chemical = factory('App\Chemical')->create(['structure_id' => $structure->id]);
        
        $this->assertEquals(999, $chemical->structure->id);
        $this->assertEquals(10, $chemical->structure->n_C);
    }

    
}
