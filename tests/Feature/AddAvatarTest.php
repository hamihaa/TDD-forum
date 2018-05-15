<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddAvatarTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function only_auth_user_can_add_avatar()
    {
        $this->withExceptionHandling();

        $this->json('POST', 'api/user/hamiha/avatar')
            ->assertStatus(401);
    }

    /** @test */
    public function valid_avatar_must_be_provided()
    {
        $this->withExceptionHandling()->signIn();

        $this->json('POST', 'api/user/'. auth()->id() . '/avatar', [
            'avatar' => 'not-an-image'
        ])->assertStatus(422);
    }

    /** @test */
    public function user_can_add_avatar_to_profile()
    {
        $this->signIn();

        //fake storage
        Storage::fake('public');

        //fake img
        $this->json('POST', 'api/user/'. auth()->id() . '/avatar', [
            'avatar' =>  $file = UploadedFile::fake()->image('avatar.jpg')
        ]);

        $this->assertEquals('avatars/' . $file->hashName(), auth()->user()->thumbnail);

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());

    }
}
