<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use App\Models\ParentInfo;
use App\Models\Student;

$factory->define(ParentInfo::class, function (Faker $faker) {
    return [
        'student_id' => function () {
            return Student::inRandomOrder()->first()->id;
        },
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->address,
        'relationship' => $faker->randomElement(['Mother', 'Father', 'Guardian']),
        'alias' => $faker->word,
        'contact' => $faker->word,
        'job' => $faker->jobTitle,
        'contact_time' => $faker->time($format = 'H:i:s', $max = 'now'),
        'main_guardian' => $faker->word,
        'line_id' => $faker->word,
        'line_token' => $faker->uuid,
        // Add other fields as needed
    ];
});
