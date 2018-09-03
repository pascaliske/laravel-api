<?php

use Faker\Generator as Faker;

$factory->define(App\Api\Models\User::class, function (Faker $faker) {
    return [
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => password_hash('12345678', PASSWORD_BCRYPT, ['cost' => 10]),
        'activated' => $faker->boolean,
        'confirmed' => $faker->boolean,
    ];
});
