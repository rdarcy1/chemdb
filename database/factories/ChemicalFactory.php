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
        'cas'               => $faker->numberBetween(10,50) . '-' . $faker->numberBetween(10,50) . '-' . $faker->numberBetween(10,50),
        'location'          => array_rand(['Fake lab I', 'Fake lab II', 'Fake lab III']),
        'number'            => $faker->numberBetween(10,400),
        'quantity'          => $faker->numberBetween(10,400) . ' mL',
        'supplier'          => array_rand(['Sigma Aldrich', 'Acros', 'Fischer Scientific', 'J&K', 'Fluorochem']),
        'purity'            => $faker->numberBetween(94, 99) .'%', 
        'molecular_weight'  => $faker->randomFloat(2, 0, 100), 
        'density'           => $faker->randomFloat(2, 0, 1), 
        'remarks'           => $faker->sentence(), 
    ];
});
