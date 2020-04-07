<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        "title_id" => factory('App\Title')->create(),
        "name" => $faker->name,
        "name_kh" => $faker->name,
        "email" => $faker->safeEmail,
        "password" => str_random(10),
        "gender" => collect(["1","2",])->random(),
        "dob" => $faker->date("d-m-Y", $max = 'now'),
        "phone" => $faker->name,
        "staff_code" => $faker->name,
        "position_id" => factory('App\Position')->create(),
        "department_id" => factory('App\Department')->create(),
        "role_id" => factory('App\Role')->create(),
        "remember_token" => $faker->name,
    ];
});
