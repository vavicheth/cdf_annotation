<?php

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        "document_id" => factory('App\Document')->create(),
        "user_id" => factory('App\User')->create(),
        "comment" => $faker->name,
        "submit" => 0,
        "user_created_id" => factory('App\User')->create(),
        "user_updated_id" => factory('App\User')->create(),
    ];
});
