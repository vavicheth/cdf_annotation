<?php

$factory->define(App\Title::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "name_kh" => $faker->name,
        "abr" => $faker->name,
        "description" => $faker->name,
    ];
});
