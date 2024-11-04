<?php

namespace Database\Factories;

use App\Models\Preference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Preference>
 */
class PreferenceFactory extends Factory
{
    protected $model = Preference::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(), // Her tercih için bir kullanıcı oluşturur
            'source' => $this->faker->randomElement(['NewsAPI', 'The Guardian', 'New York Times']),
            'category' => $this->faker->randomElement(['Technology', 'Health', 'Sports']),
            'author' => $this->faker->name,
        ];
    }
}
