<?php

use App\Bottle;
use Faker\Generator as Faker;

$factory->define(Bottle::class, function (Faker $faker) {
    return [
        'chemical_id'   => function() { return factory('App\Chemical')->create()->id; },
        'quantity'      => $faker->randomNumber(2) . ' g',
        'purity'        => $faker->randomNumber(2) . ' % pure',
        'location'      => 'Fake Lab 1, Cabinet 6, #103',
        'supplier'      => 'Sigma Aldrich',
        'order'         => 'Fake Order-No-'.$faker->randomNumber(4).'W',
        'notes'         => 'Fake notes'
    ];
});
