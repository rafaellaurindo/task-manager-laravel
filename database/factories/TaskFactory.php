<?php

use Faker\Generator as Faker;

$factory->define(\App\Task::class, function (Faker $faker) {
    return [
        'name'   => $faker->sentence(2),
        'description'   => $faker->text,
        'priority'  => $faker->randomElement(['Baixa', 'Média', 'Alta', 'Muito Alta']),
        'term'  => $faker->dateTime()->format('Y-m-d H:i:s'),
        'is_completed' => $faker->randomElement(['0','1']),
    ];
});
