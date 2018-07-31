<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BottlesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_bottle_has_a_quantity()
    {
        $bottle = factory('App\Bottle')->create(['quantity' => '25 g']);
        $this->assertEquals('25 g', $bottle->quantity);
    }

    /** @test */
    function a_bottle_has_a_supplier()
    {
        $bottle = factory('App\Bottle')->create(['supplier' => 'Sigma Aldrich']);
        $this->assertEquals('Sigma Aldrich', $bottle->supplier);
    }

    /** @test */
    function a_bottle_has_a_location()
    {
        $bottle = factory('App\Bottle')->create(['location' => 'Fake lab 2, cabinet 1, #102']);
        $this->assertEquals('Fake lab 2, cabinet 1, #102', $bottle->location);
    }

    /** @test */
    function a_bottle_has_an_order_reference()
    {
        $bottle = factory('App\Bottle')->create(['order' => 'FakeOrderNumber-001']);
        $this->assertEquals('FakeOrderNumber-001', $bottle->order);
    }

    /** @test */
    function a_bottle_has_notes()
    {
        $bottle = factory('App\Bottle')->create(['notes' => 'fake notes']);
        $this->assertEquals('fake notes', $bottle->notes);
    }

    /** @test */
    function a_bottle_has_a_purity()
    {
        $bottle = factory('App\Bottle')->create(['purity' => '99% fake purity']);
        $this->assertEquals('99% fake purity', $bottle->purity);
    }

    /** @test */
    function a_bottle_belongs_to_a_chemical()
    {
        $chemical= factory('App\Chemical')->create(['id' => 999, 'name' => 'Fake chemical']);
        $bottle = factory('App\Bottle')->create(['chemical_id' => $chemical->id]);

        $this->assertEquals(999, $bottle->chemical->id);
        $this->assertEquals('Fake chemical', $bottle->chemical->name);
    }



}
