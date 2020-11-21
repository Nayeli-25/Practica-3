<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Productos;
use Faker\Generator as Faker;


$factory->define(Productos::class, function (Faker $faker) {
    return [
        'Producto' => $faker->sentence(2),
        'Publicado_por' => App\Models\User::all()->random()->id,
    ];
});
