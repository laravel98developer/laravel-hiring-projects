<?php

namespace Article;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;
use Modules\Article\App\Models\Article;
use Tests\TestCase;

class ArticleTest extends TestCase
{

    /**
     * Test creating an article.
     *
     * @test
     */
    public function it_creates_an_article()
    {
        $user = User::factory()->count(1)->create()[0]->generate_token();
        $article = Article::factory()->count(1)->make()[0];
        $response = $this->postJson('/api/article', [
            'title' => $article->title,
            'content' => $article->content,
            'publication_date' => $article->publication_date,
            'publication_status' => $article->publication_status,
        ], ["Authorization" => "Bearer " . $user->access_token]);

        $response->assertStatus(201); // Assuming you return HTTP status 201 for successful order creation
        $this->assertDatabaseHas('articles', ['title' => $article->title]); // Assuming 'orders' is your orders table
    }

    /**
     * Test updating an article.
     *
     * @test
     */
    public function it_updates_an_article()
    {
        $user = User::factory()->count(1)->create()[0]->generate_token();
        $roleId = rand(1, 3);
        $user->roles()->attach($roleId);
        $article = Article::factory()->count(1)->create(function ($q) use ($user, $roleId) {
            if ($roleId == 3) {
                return ["user_id" => $user->id];
            } else {
                return [];
            }
        })[0];
        $data = Article::factory()->count(1)->make()[0];
        $response = $this->patchJson('/api/article/' . $article->id, [
            'title' => $data->title,
            'content' => $data->content,
            'publication_date' => $data->publication_date,
            'publication_status' => $data->publication_status,
        ], ["Authorization" => "Bearer " . $user->access_token]);

        $response->assertStatus(200); // Assuming you return HTTP status 201 for successful order creation
        $this->assertDatabaseHas('articles', ['title' => $data->title]); // Assuming 'orders' is your orders table
    }

    /**
     * Test finding an article by ID.
     *
     * @test
     */
    public function it_find_an_article_by_id()
    {
        $article = Article::factory()->create();
        $user = $article->user()->first()->generate_token();
        $user->roles()->attach(3);
        $response = $this->getJson('/api/article/' . $article->id, ["Authorization" => "Bearer " . $user->access_token]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('articles', ['title' => $article->title]);
    }

    /**
     * Test paginating articles.
     *
     * @test
     */
    public function it_articles_paginate()
    {
        $user = User::factory()->create()->generate_token();
        $user->roles()->attach(2);
        Article::factory()->count(500)->create();
        $response = $this->getJson('/api/article', ["Authorization" => "Bearer " . $user->access_token]);
        $response->assertStatus(200);
    }

    /**
     * Test paginating articles by User ID.
     *
     * @test
     */
    public function it_articles_by_user_id_paginate()
    {
        $user = User::factory()->create()->generate_token();
        $user->roles()->attach(3);
        Article::factory()->count(500)->create(["user_id"=>$user->id]);
        $response = $this->getJson('api/article/by-user', ["Authorization" => "Bearer " . $user->access_token]);
        $response->assertStatus(200);
    }

    /**
     * Test changing the status of an article.
     *
     * @test
     */
    public function it_change_status_an_articles()
    {
        $user = User::factory()->create()->generate_token();
        $user->roles()->attach(2);
        $article = Article::factory()->create();
        $data = [];
        if ($article->status == "draft") {
            $data['publication_status'] = "publish";
        } else {
            $data['publication_status'] = "draft";
        }
        $response = $this->patchJson("/api/article/status/$article->id",$data, ["Authorization" => "Bearer " . $user->access_token]);
        $response->assertStatus(200);
    }

    /**
     * Test deleting an article.
     *
     * @test
     */
    public function it_delete_an_articles()
    {
        $user = User::factory()->create()->generate_token();
        $user->roles()->attach(2);
        $article = Article::factory()->create();
        $response = $this->deleteJson("/api/article/$article->id",[], ["Authorization" => "Bearer " . $user->access_token]);
        $response->assertStatus(200);
    }

    protected
    function setUp(): void
    {
        parent::setUp();
    }
}
