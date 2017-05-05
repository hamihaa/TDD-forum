<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{

    use DatabaseMigrations;


    /** if not logged in, cant add reply
     *
     * @test */
    function  unauthenticated_users_cant_add_replies()
    {
        /*
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = create('App\Thread');

        $reply = make('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());
        */
        $this->withExceptionHandling()
             ->post('threads/some-category/1/replies', [])
            ->assertRedirect('/login');
    }

    /**
     * create and log in an user($this->be($user)),
     * create random thread,
     * post a reply with given user,
     * check if reply is visible
     * @test
     * */
    public function an_authenticated_user_can_participate()
    {
        //can use following syntax, if utilities/functions.php is not created
        //$user = factory('App\User')->create();
        $user = create('App\User');
        $this->be($user);

        $thread = create('App\Thread');

        $reply = make('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
        ->assertSee($reply->body);
    }

    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
             ->assertSessionHasErrors('body');

    }

}
