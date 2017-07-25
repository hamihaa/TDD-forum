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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->unique()->name,
        'email' => $faker->unique()->safeEmail,
        'first_name' => $faker->name,
        'last_name' => $faker->lastName,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'last_login' => date("Y-m-d H:i:s")
    ];
});

//factory faker for generating threads
$factory->define(App\Thread::class, function ($faker) {
    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'category_id' => function() {
            return factory('App\Category')->create()->id;
        },
        'thread_status_id' => function() {
            return factory('App\ThreadStatus')->create()->id;
        },
      'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
} );

//factory faker for generating thread replies
$factory->define(App\Reply::class, function ($faker) {
    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'thread_id' => function() {
            return factory('App\Thread')->create()->id;
        },
        'body' => $faker->paragraph
    ];
} );

//factory faker for generating categories
$factory->define(App\Category::class, function ($faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name
    ];
} );

//factory faker for generating categories
$factory->define(App\Tag::class, function ($faker) {
    $name = $faker->word;
    return [
        'name' => $name
    ];
} );

//factory faker for generating status
$factory->define(App\ThreadStatus::class, function ($faker) {
    $name = $faker->word;

    return [
        'status_name' => $name
    ];
} );

//factory for notifications
$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function ($faker) {

    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function () {
            return auth()->id() ?: factory('App\User')->create()->id;
        },
        'notifiable_type' => 'App\User',
        'data' => ['foo' => 'bar']
    ];
} );

//factory for thread votes
$factory->define(App\ThreadVote::class, function ($faker) {

    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'thread_id' => function() {
            return factory('App\Thread')->create()->id;
        },
        'vote_type' => 1
    ];
} );
