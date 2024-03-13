<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected User $currentUser;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs($this->currentUser = User::factory()->create());
    }

    public function testPostsList(): void
    {
        Post::factory()->count(50)->create();

        $response = $this->get('api/posts');

        $response->assertOk();

        $this->assertIsArray($response->json('data'));
        $this->assertCount(15, $response->json('data'));
    }

    public function testUserCanCreateNewPost(): void
    {
        $response = $this->post("api/posts", $data = Post::factory()->makeOne()->toArray());

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'body',
            ]
        ]);

        $this->assertDatabaseHas(Post::class, [
            'user_id' => $this->currentUser->id,
            'title' => $data['title'],
        ]);
    }

    public function testPostCanBeShown(): void
    {
        $posts = Post::factory()->count(15)->create();

        $randomPost = $posts->random()->first();

        $response = $this->get("api/posts/$randomPost->id");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'body',
            ]
        ]);
    }

    public function testUserCanEditHisPost(): void
    {
        $post = Post::factory()->for($this->currentUser)->createOne();

        $response = $this->patch("api/posts/$post->id", $updatedPostData = Post::factory()->makeOne()->toArray());

        $response->assertOk();

        $this->assertEquals($updatedPostData['title'], $post->refresh()->title);
    }

    public function testUserCanDeleteHisPost(): void
    {
        $post = Post::factory()->for($this->currentUser)->createOne();

        $response = $this->delete("api/posts/$post->id");

        $response->assertOk();

        $this->assertSoftDeleted($post);
    }

    public function testUserCantEditOthersPosts(): void
    {
        $post = Post::factory()->createOne();

        $response = $this->patch("api/posts/$post->id", Post::factory()->makeOne()->toArray());

        $response->assertForbidden();
    }

    public function testUserCantDeleteOthersPosts(): void
    {
        $post = Post::factory()->createOne();

        $response = $this->delete("api/posts/$post->id");

        $response->assertForbidden();

        $this->assertNotSoftDeleted($post);
    }
}
