<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LikesTest extends TestCase
{
    use DatabaseTransactions;


    public function setUp() : void
    {
        parent::setUp();

        $this->post = Post::factory()->create();

        $this->signIn();

    }
    /**
    * @test
    *
    * @return void
    **/
    public function a_user_can_like_a_post()
    {
        $this->post->like();

        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id
        ]);

        $this->assertTrue($this->post->isLiked());
    }

    /**
    * @test
    *
    * @return void
    **/
    public function a_user_can_unlike_the_post()
    {
        $this->post->like();
        $this->post->unlike();

        $this->assertDatabaseMissing('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id
        ]);

        $this->assertFalse($this->post->isLiked());
    }

        /**
    * @test
    *
    * @return void
    **/
    public function a_user_can_toogle_likes_the_post()
    {
        $this->post->toogle();

        $this->assertTrue($this->post->isLiked());

        $this->post->toogle();

        $this->assertFalse($this->post->isLiked());

    }

    /**
    * @test
    *
    * @return void
    **/
    public function a_post_returns_how_many_likes_it_has()
    {
        $this->post->toogle();

        $this->assertEquals(1, $this->post->likesCount());
    }

}
