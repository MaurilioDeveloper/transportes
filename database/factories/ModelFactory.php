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

require_once __DIR__ . '/documento.php';

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Models\Parceiro::class, function (Faker\Generator $faker) {

    $cpfs = cpfs();
    return [
        'nome' => $faker->name,
        // Pega uma posição aleatoria (array_rand)
        'documento' => $cpfs[array_rand($cpfs,1)],
        'email' => $faker->safeEmail,
        'telefone' => $faker->phoneNumber,
        'endereco' => $faker->streetAddress,
        'numero' => $faker->randomNumber(),
        'complemento' => $faker->word,
        'bairro' => $faker->word,
        'cep' => $faker->address,
        'cidade' => $faker->city,
        'estado' => \App\Models\Parceiro::ESTADOS,
        'site' => $faker->domainName
    ];
});

$factory->state(App\Models\Parceiro::class, 'pessoa_fisica', function(Faker\Generator $faker){
    $cpfs = cpfs();

    return [
        'documento' => $cpfs[array_rand($cpfs,1)],
        'data_nasc' => $faker->date(),
        'estado_civil' => rand(1,3),
        'sexo' => rand(1, 10) % 2 == 0 ? 'm': 'f',
        'deficiencia_fisica' => $faker->word,
        'pessoa' => \App\Models\Parceiro::PESSOA_FISICA
    ];
});

$factory->state(App\Models\Parceiro::class, 'pessoa_juridica', function(Faker\Generator $faker){
    $cnpjs = cnpjs();

    return [
        'documento' => $cnpjs[array_rand($cnpjs,1)],
        'fantasia'  => $faker->company,
        'inscricao_estadual' => rand(1, 10),
        'pessoa' => \App\Models\Parceiro::PESSOA_JURIDICA
    ];
});
