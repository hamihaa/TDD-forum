<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadVoteTest extends TestCase
{
    use DatabaseMigrations;

    /** test */
    public function guests_cant_vote()
    {
        $thread = create('App\Thread');
        $this->withExceptionHandling()
            ->post("{$thread->path()}/vote")
            ->assertRedirect('/login');
    }

    /** @test */
    public function user_can_vote_on_a_thread()
    {
        //creating a thread
        $this->signIn();
        $thread = create('App\Thread', ['thread_status_id' => 2]);

        // sub to thread
        $this->post("{$thread->path()}/votes", [
            'vote_type' => 0
        ]);

        $this->assertCount(1, $thread->fresh()->votes);
    }

    /** @test */
    public function user_can_unvote_thread()
    {
        //creating a thread
        $this->signIn();
        $thread = create('App\Thread', ['thread_status_id' => 2]);

        //create upvote
        $thread->votes()->create([
            'user_id' => auth()->id(),
            'vote_type' => '1'
        ]);

        // sub to thread
        $this->delete("{$thread->path()}/votes");
        $this->assertCount(0, $thread->votes);
    }

    /**
     * @test
     */
    public function user_can_change_vote_type()
    {
        $this->signIn();
        $thread = create('App\Thread', ['thread_status_id' => 2]);
        //create upvote
        $thread->votes()->create([
            'user_id' => auth()->id(),
            'vote_type' => '1'
        ]);

        $this->assertCount(1, $thread->votes);
        // sub to thread
        $this->patch("{$thread->path()}/votes", [
            'user_id' => auth()->id(),
            'vote_type' => '0'
        ]);
        $this->assertCount(1, $thread->fresh()->votes);
    }
}
