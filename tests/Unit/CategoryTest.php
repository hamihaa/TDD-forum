<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{

    use DatabaseMigrations;

    /**
     *checks if created thread is available in category->threads
     * @test */
    public function category_has_threads()
    {
        $category = create('App\Category');
        $thread = create('App\Thread', ['category_id' => $category->id]);

        $this->assertTrue($category->threads->contains($thread));
    }
}
