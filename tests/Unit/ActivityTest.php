<?php

namespace Tests\Unit;

use App\Activity;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function records_activity_when_thread_is_created()
    {

        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity= Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }
    /**
     * @test
     */
    public function records_activity_when_reply_is_created()
    {
        $this->signIn();

        //creates two activities, one for thread, other for reply!
        $reply = create('App\Reply');

        $this->assertEquals(2, Activity::count());
    }

    /**
     * Creates two threads from different dates and checks if the display is correct
     * @test
     */
    public function fetches_a_feed_for_any_user()
    {
        $this->signIn();

        //create 2 threads
        create('App\Thread', [
            'user_id' => auth()->id(),
        ], 2);

        //for the purpose of our test, we must manually change the date of first activity
        //to simulate, that it was created a week ago
        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::getUserActivity(auth()->user());

        //check that it contains the thread created at this time
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('d.m.Y')
        ));

        //check that it contains the thread created a week ago ( ->subWeek())
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('d.m.Y')
        ));
    }

}
