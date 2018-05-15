<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Guest cant view /threads/create and cant post to /threads
     * @test
     */
    public function guest_cant_create_threads()
    {

        $this->withExceptionHandling();

        $this->get('/threads/create')
             ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
}

    /**
     * @test
     */
    public function authenticated_user_can_create_thread()
    {
        // instead of
        //$this->actingAs(create('App\User'));
        // use helper function signIn created in TestCase.php file

        $this->signIn();

        // raw returns an array instead of an object
        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title);
            //->assertSee($thread->body);

    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');

    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');

    }

    /** test */
    public function a_thread_requires_a_valid_category()
    {
        factory('App\Category', 2)->create();

        //return error if category id is noull
        $this->publishThread(['category_id' => null])
            ->assertSessionHasErrors('category_id');

        //return error if category id doesn't exist in db
        $this->publishThread(['category_id' => 99])
            ->assertSessionHasErrors('category_id');


    }

    public function publishThread($overrides = [])
    {

        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
