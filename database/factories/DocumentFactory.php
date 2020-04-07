<?php

$factory->define(App\Document::class, function (Faker\Generator $faker) {
    return [
        "letter_code" => $faker->name,
        "code_in" => $faker->name,
        "document_code" => $faker->name,
        "oranization" => $faker->name,
        "description" => $faker->name,
        "submit" => 0,
        "user_created_id" => factory('App\User')->create(),
        "user_updated_id" => factory('App\User')->create(),
    ];
});
