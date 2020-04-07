<?php

$factory->define(App\Department::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "name_kh" => $faker->name,
        "description" => $faker->name,
        "user_created_id" => factory('App\User')->create(),
        "user_updated_id" => factory('App\User')->create(),
    ];
});
