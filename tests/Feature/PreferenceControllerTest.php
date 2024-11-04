<?php

namespace Tests\Feature;

use App\Models\Preference;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PreferenceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_set_preferences()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/preferences', [
            'source' => 'NewsAPI',
            'category' => 'Technology',
            'author' => 'Muzaffer DOGAN',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('preferences', ['user_id' => $user->id, 'source' => 'NewsAPI']);
    }

    public function test_get_preferences()
    {
        $user = User::factory()->create();
        Preference::factory()->create(['user_id' => $user->id, 'source' => 'NewsAPI']);
        $this->actingAs($user);

        $response = $this->getJson('/api/preferences');

        $response->assertStatus(200)
            ->assertJsonFragment(['source' => 'NewsAPI']);
    }
}
