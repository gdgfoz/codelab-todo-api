<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(GDGFoz\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});



$factory->define(\GDGFoz\Category::class, function (Faker\Generator $faker) {

    return [
        'category' => $faker->sentence,
        'path_img' => $faker->imageUrl(400, 500, 'food'),
        'color'    => $faker->hexColor
    ];

});

$factory->define(\GDGFoz\Task::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->sentence,
        'description' => $faker->paragraph(2),
        'user_id' => $faker->randomElement( \GDGFoz\User::get()->lists('id')->toArray() ),
        'category_id' => $faker->randomElement( \GDGFoz\Category::get()->lists('id')->toArray() ),
        'status' => $faker->boolean(20),
    ];

});