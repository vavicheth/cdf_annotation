<?php

$factory->define(App\Position::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "name_kh" => $faker->name,
        "description" => $faker->name,
    ];
});
