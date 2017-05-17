<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_cant_favorite()
    {
        $this->withExceptionHandling()
             ->post('replies/1/favorite')
             ->assertRedirect('/login');

    }

    /**
     *  /replies/id/favorite
     * @test
     */
    public function an_authenticated_user_can_favourite_reply()
    {
        $this->signIn();
        //this also creates new Thread
        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/favorite');

        //check if it was posted in db
        $this->assertCount(1, $reply->favorites);
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_unfavourite_reply()
    {
        $this->signIn();
        //this also creates new Thread
        $reply = create('App\Reply');
        $reply->addFavorite();

        $this->delete('replies/' . $reply->id . '/favorite');

        //check if it was posted in db
        $this->assertCount(0, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_favourite_reply_only_once()
    {
        $this->signIn();
        //this also creates new Thread
        $reply = create('App\Reply');

        try{
            $this->post('replies/' . $reply->id . '/favorite');
            $this->post('replies/' . $reply->id . '/favorite');
        } catch (\Exception $e){
            $this->fail('Can insert only once!');
        }

        //check if it has only 1 record in db
        $this->assertCount(1, $reply->favorites);
    }
}
