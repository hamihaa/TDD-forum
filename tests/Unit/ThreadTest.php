<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasCommented;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{

    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /* @test */
    public function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');

        $this->assertEquals("/threads/{$thread->category->slug}/{$thread->id}", $thread->path());
    }
    /**
     * Checks if a thread has replies (returns collection, so check if InstanceOf)
     * @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }


    /**
     * checks if owner of thread is an instance of User
     * @test */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /** @test  */
    public function a_thread_belongs_to_a_status()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\ThreadStatus', $thread->status);
    }

    /** @test  */
    public function a_thread_belongs_to_many_tags()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->tags);
    }

    /**
     * adds a reply to a thread,
     * checks if reply exists
     *
     * @test
     */
    public function a_thread_can_add_a_reply()
    {

        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function  thread_notifies_all_registered_subs_when_a_reply_is_added()
    {
        //replace underlying instance with a fake version
        Notification::fake();

        $this->signIn();

        $this->thread->subscribe();

        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 999
        ]);

        Notification::assertSentTo(auth()->user(), ThreadWasCommented::class);
    }

    /*
    * @test  */
    public function a_thread_belongs_to_a_category()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Category', $thread->category);
    }

    /* @test */
    public function a_thread_can_be_subscribed_to()
    {
        $thread = create('App\Thread');

        //instead of using $this->signIn(), pass $userId
        $thread->subscribe($userId = 1);

        $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id', $userId)->count()
        );
    }

    /* @test */
    public function a_thread_can_be_unsubscribed_from()
    {
        $thread = create('App\Thread');

        //instead of using $this->signIn(), pass $userId
        $thread->subscribe($userId = 1);
        $thread->unsubscribe($userId);

        $this->assertEquals(
            1,
            $thread->assertCount(0, $thread->subscriptions)
        );
    }

    /* @test */
    function it_returns_if_auth_user_is_subscribed_to_this_thread()
    {
        $thread = create('App\Thread');
        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }
}
