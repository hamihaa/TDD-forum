<?php

namespace Tests\Feature;

use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteThreadTest extends TestCase
{
    use DatabaseMigrations;


    /**
     * Testing for any type of user
     * @test
     */
    public function a_guest_cant_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $response = $this->delete($thread->path());

        $response->assertRedirect('/login');
    }

    /**
     * Further testing, only authorised users can delete
     * @test
     */
    public function unauthorized_user_cant_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete($thread->path())
            ->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    /**
     * Delete also removes all replies asociated with thread
     * @test
     */
    public function authorized_user_can_delete_thread()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);
        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        //delete action also deletes all replies associated with thread
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        //assert that there are 0 records in activity table
        $this->assertEquals(0, Activity::count());


    }

    /**
     * @test
     */
    function unauthorized_user_cant_delete_reply()
    {
        $this->withExceptionHandling();

        $reply =create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /**
     * @test
     */
    function authorized_user_can_delete_reply()
    {
        $this->signIn();

        $reply =create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);;

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

}
