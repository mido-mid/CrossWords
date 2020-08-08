<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Translator;
use App\Language;
use App\ClientFiles;
use App\TranslatorFiles;
use App\Photo;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->word,
        'last_name' => $faker->word,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'role' => $faker->randomElement([0, 1]),
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Language::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->randomElement([15,20,25,30,35,40]),
    ];
});


$factory->define(Translator::class, function (Faker $faker) {
    return [
        'first_name' => $faker->word,
        'last_name' => $faker->word,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'language_id' => Language::all()->random()->id,
        'approved' => $faker->randomElement([0, 1]),
        'remember_token' => Str::random(10),
    ];
});



$factory->define(ClientFiles::class, function (Faker $faker) {
    return [
        'filename' => $faker->randomElement(['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','7.jpg','8.jpg','9.jpg','10.jpg',]),
        'user_id' => User::all()->random()->id,
        'translator_id' => Translator::all()->random()->id,
        'target_language' => Language::all()->random()->id,
        'source_language' => Language::all()->random()->id,
        'words' => $faker->randomElement([15,20,25,30,35,40]),
        'total_price' => $faker->randomElement([100,200,300,400]),
    ];
});


$factory->define(TranslatorFiles::class, function (Faker $faker) {
    return [
        'filename' => $faker->randomElement(['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg','7.jpg','8.jpg','9.jpg','10.jpg',]),
        'user_id' => User::all()->random()->id,
        'translator_id' => Translator::all()->random()->id,
        'target_language' => Language::all()->random()->id,
        'source_language' => Language::all()->random()->id,
        'words' => $faker->randomElement([15,20,25,30,35,40]),
    ];
});

$factory->define(Photo::class, function (Faker $faker) {

	$user_id = User::all()->random()->id;
    $translator_id = Translator::all()->random()->id;
    $language_id = Language::all()->random()->id;

	$photoable_id = $faker->randomElement([ $user_id,$translator_id,$language_id ]);
	$photoable_type = $photoable_id == $user_id ? 'App\User' : ($photoable_id == $translator_id ? 'App\Translator' : 'App\Language');

    return [
    	'filename' => $faker->randomElement(['1.png','2.png','3.png','4.png']),

    	'photoable_id' => $photoable_id,
    	'photoable_type' => $photoable_type,
    ];
});


