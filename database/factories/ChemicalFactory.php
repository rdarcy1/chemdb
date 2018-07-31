<?php

use Faker\Generator as Faker;
use App\Chemical;

$factory->define(Chemical::class, function (Faker $faker) {
    $alkyl = ['metyl', 'ethyl', 'butyl'];
    $substitutionPosition = $faker->numberBetween(1,4);
    $substitutionGroup = ['bromo', 'aceto', 'iodo', 'amino'];
    $postfix = ['acetate', 'carbonate', 'diol', 'diamine', 'formate', 'peroxide'];

    $fakeName = $alkyl[array_rand($alkyl)] . '-' . $substitutionPosition . '-' . $substitutionGroup[array_rand($substitutionGroup)] . ' ' . $postfix[array_rand($postfix)];

    return [
        'name'              => $fakeName,
        'user_id'           => function() { return factory('App\User')->create()->id; },
        'structure_id'      => function() { return factory('App\Structure')->create()->id; },
        'cas'               => $faker->numberBetween(10,50) . '-' . $faker->numberBetween(10,50) . '-' . $faker->numberBetween(10,50),
        'molecular_weight'  => $faker->randomFloat(2, 0, 100),
        'density'           => $faker->randomFloat(2, 0, 1), 
        'remarks'           => $faker->sentence(), 
    ];
});
