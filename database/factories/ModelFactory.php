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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

/*$factory->define(App\Course::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'enable' => 'si',
    ];
});

$factory->define(App\Student::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'first_surname'=>$faker->lastName,
        'second_surname'=>$faker->lastName,
        'document_type'=>'CC',
        'document_of_identity'=>$faker->postcode,
        'age'=>$faker->randomDigit,
        'address'=>$faker->address,
        'contact_name'=>$faker->phoneNumber,
        'one_contact_phone'=>$faker->phoneNumber,
        'two_contact_phone'=>$faker->name,
        'email'=>$faker->email,
        'enable' => 'si'
    ];
});*/


        $factory->define(App\Company::class, function (Faker\Generator $faker) {
            return [
                'name' => $faker->name,
                'description' => $faker->text,
                'enable' => 'si',
            ];
        });


      $factory->define(App\Roles::class, function (Faker\Generator $faker) {
            return [
                'rol' => $faker->name,
                'enable' => 'si',
            ];
        });