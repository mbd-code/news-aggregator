<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'author' => $this->faker->name,
            'source' => $this->faker->randomElement(['NewsAPI', 'The Guardian', 'New York Times']),
            'category' => $this->faker->randomElement(['Technology', 'Health', 'Sports']),
            'published_at' => $this->faker->dateTimeThisYear,
        ];
    }
}
