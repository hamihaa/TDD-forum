<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function authenticated_user_can_update_thread()
    {

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $status = create('App\ThreadStatus');

        $this->patch($thread->path(), ['thread_status_id' => $status->id]);

        $this->assertDatabaseHas('threads', ['id' => $thread->id, 'thread_status_id' => $status->id]);
    }
}
