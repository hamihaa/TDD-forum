<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{

    use DatabaseMigrations;

    // used for declaring and creating new test Thread object
    // on every test function
    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_browse_threads()
    {
        $response = $this->get('/threads');
        //$response->assertStatus(200);
        $response->assertSee($this->thread->body);
    }

    /** @test */
    public function a_user_can_see_a_single_thread()
    {
        $response = $this->get($this->thread->path());

        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_on_a_thread()
    {
        //generates 1 reply for our test thread
        $reply = create('App\Reply' ,['thread_id' => $this->thread->id]);
        //go to thread page
        $response = $this->get($this->thread->path());
        //check if request has the body of reply on our thread
        $response->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_by_tag()
    {
        $category = create('App\Category');
        $threadInCategory = create('App\Thread', ['category_id' => $category]);
        $threadNotInCategory = create('App\Thread');

        $this->get('/threads/' . $category->slug)
            ->assertSee($threadInCategory->title)
            ->assertDontSee($threadNotInCategory->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadFromJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotFromJohn = create('App\Thread');

        $this->get('/threads?by=JohnDoe')
            ->assertSee($threadFromJohn->title)
            ->assertDontSee($threadNotFromJohn->title);

    }

    /** Testing that threads with 3, 2, 0 replies are in order
     *  */
    public function user_can_filter_threads_by_popular()
    {
        //thread, that is created by default with setUp
        $threadWithNoReplies = $this->thread;

        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);


        //filtering threads by popular
        $response = $this->getJson('/threads?popular=1')->json();

        //should return from most to least popular
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
