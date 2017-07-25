<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadStatusTest extends TestCase
{

    use DatabaseMigrations;

    /**
     *checks if created thread is available in category->threads
     * @test */
    public function status_has_threads()
    {
        $status = create('App\ThreadStatus');
        $thread = create('App\Thread', ['thread_status_id' => $status->id]);

        $this->assertTrue($status->threads->contains($thread));
    }

    /** @test */
    public function threads_status_can_be_changed()
    {
        $status = create('App\ThreadStatus');
        $thread = create('App\Thread', ['thread_status_id' => $status->id]);

        $this->assertEquals($thread->thread_status_id, $status->id);

        $status2 = create('App\ThreadStatus');
        $thread->changeStatus($status2->id);

        $this->assertEquals($thread->fresh()->thread_status_id, $status2->id);
    }
}
