<?php

namespace Tests\Feature;

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
    }

    /**
     * @test
     */
    public function threads_can_be_deleted_only_by_users_with_permission()
    {
        // TODO
    }
}
