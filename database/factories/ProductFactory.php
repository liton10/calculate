<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->text,
        'price' => $faker->randomNumber(3),
        'file_path' => 'images/2030303451.jpg',
        'original_filename' => 'testfile.jpg',
    ];
});
