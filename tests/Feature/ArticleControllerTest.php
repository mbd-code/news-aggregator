<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_articles()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Article::factory()->count(5)->create();

        $response = $this->getJson('/api/articles');

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [['id', 'title', 'content', 'source']]]);
    }

    public function test_search_articles()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Article::factory()->create(['title' => 'Tech News']);
        Article::factory()->create(['title' => 'Sports News']);

        $response = $this->getJson('/api/articles/search?keyword=Tech');

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Tech News']);
    }

    public function test_create_article()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/articles', [
            'title' => 'New Article',
            'content' => 'Article content',
            'source' => 'NewsAPI',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('articles', ['title' => 'New Article']);
    }
}
