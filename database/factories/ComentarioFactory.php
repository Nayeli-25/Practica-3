<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Comentarios;
use Faker\Generator as Faker;

/**$faker = Carbon\Factory::create('es_ES');**/

$factory->define(Comentarios::class, function (Faker $faker) {
    return [
        'comentario' => $faker->text(50),
        'persona_id' => App\Models\User::all()->random()->id,
        'producto_id' => App\Models\Productos::all()->random()->id,
        'created_at' => $faker->date(),
        'updated_at' => now(),
    ];
});
