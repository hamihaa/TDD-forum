<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubscribeToThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_sub_to_thread()
    {
        //creating a thread
        $this->signIn();
        $thread = create('App\Thread');

        // sub to thread
        $this->post("{$thread->path()}/subscriptions");
        //when reply is left
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'koment'
        ]);
        //a notification is left
        //$this->asserCount(1, auth()->user()->notifications);
    }

    /** @test */
    public function user_can_unsub_from_thread()
    {
        //creating a thread
        $this->signIn();
        $thread = create('App\Thread');
        $thread->subscribe();
        // sub to thread
        $this->delete("{$thread->path()}/subscriptions");
        $this->assertCount(0, $thread->subscriptions);
    }

}
