<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @test
     */
    public function users_mentioned_in_a_reply_are_notified()
    {
        $miha = create('App\User', ['name' => 'MihaB' ]);
        $this->signIn($miha);

        $jane = create('App\User', ['name' => 'JaneD' ]);

        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'user_id' => $miha->id,
            'body' => 'hey @JaneD I tagged you.'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);

    }
}
