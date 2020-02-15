<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Notification;
use Faker\Generator as Faker;

$factory->define(Notification::class, function (Faker $faker) {
    return [
        'created_at' => now(),
        'updated_at' => now(),
        'ar_title' => $faker->name,
        'en_title' => $faker->name,
        'ar_message' => $faker->sentence,
        'en_message' => $faker->sentence,
        'is_read' => 0,
        'product_id' => $faker->randomElement( range(2,24)),
        'receiver_id' => 6
    ];
});
