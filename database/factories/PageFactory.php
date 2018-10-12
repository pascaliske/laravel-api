<?php

use Faker\Generator as Faker;

$factory->define(App\Api\Models\Page::class, function (Faker $faker) {
    return [
        'components' => [],
        'published' => true,
    ];
});
