<?php

use Faker\Generator as Faker;

$factory->define(App\Api\Models\User::class, function (Faker $faker) {
    return [
        'activated' => false,
        'confirmed' => false,
    ];
});
