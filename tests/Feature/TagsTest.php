<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function threadCanAddTags()
    {
        $this->signIn();

        // raw returns an array instead of an object
        $thread = create('App\Thread');
        $tag = create('App\Tag');
        $tag2 = create('App\Tag');
        $tag3 = create('App\Tag');

        $thread->tags()->attach([$tag->id, $tag2->id, $tag3->id]);

        return $this->assertEquals(3, $thread->fresh()->tags()->count());
    }

    /** @test */
    public function threadCanGetTagsRemoved()
    {
        $this->signIn();

        // raw returns an array instead of an object
        $thread = create('App\Thread');
        $tag = create('App\Tag');
        $tag2 = create('App\Tag');
        $tag3 = create('App\Tag');

        $thread->tags()->attach([$tag->id, $tag2->id, $tag3->id]);

        $this->assertEquals(3, $thread->fresh()->tags()->count());

        $thread->tags()->detach([$tag->id, $tag2->id, $tag3->id]);

        return $this->assertEquals(0, $thread->fresh()->tags()->count());
    }
}
