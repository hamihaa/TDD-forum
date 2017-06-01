<?php

namespace Tests\Feature;

use Illuminate\Notifications\DatabaseNotification;
use Symfony\Component\VarDumper\Cloner\Data;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;


    /**
     * sign in on boot
     */
    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /**
     * @test
     */
    function user_can_fetch_his_unread_notifications()
    {
        create(DatabaseNotification::class);
        // easy way, requires to first create thread, cubscribe, and add reply. solution below
//        $thread = create('App\Thread')->subscribe();
//
//        $thread->addReply([
//            'user_id' => create('App\User')->id,
//            'body' => 'koment'
//        ]);

        $user = auth()->user();

        $response = $this->getJson("profiles/{$user->name}/notifications")->json();

        $this->assertCount(1, $response);

    }

    /** @test */
    function notification_is_created_when_subscribed_thread_gets_a_reply_not_by_the_current_user()
    {
        $thread = create('App\Thread')->subscribe();

        //before reply is left, should be 0 notifications
        $this->assertCount(0, auth()->user()->notifications);

        //when reply is left
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'koment'
        ]);
        //a notification is not created for the owner of reply
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        //when reply is left by somebody else
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'koment'
        ]);
        //we should get a notification
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }
    /** @test */
    function a_user_can_clear_a_notification()
    {
        create(DatabaseNotification::class);
//        $thread = create('App\Thread')->subscribe();
//
//        //reply is left
//        $thread->addReply([
//            'user_id' => create('App\User')->id,
//            'body' => 'koment'
//        ]);

        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;
        $this->delete("profiles/{$user->name}/notifications/{$notificationId}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }

}
