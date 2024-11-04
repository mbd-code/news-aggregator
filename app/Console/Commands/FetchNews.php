<?php

namespace App\Console\Commands;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull news articles from various APIs';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle(): void
    {
        $this->fetchFromNewsAPI();
        $this->fetchFromGuardianAPI();
        $this->fetchFromNYTimesAPI();
    }


    protected function fetchFromNewsAPI(): void
    {
        $apiKey = env('NEWSAPI_KEY');
        $response = Http::get("https://newsapi.org/v2/top-headlines?country=us&apiKey=$apiKey");

        if ($response->successful()) {
            foreach ($response->json()['articles'] as $news) {
                Article::updateOrCreate(
                    ['title' => $news['title']],
                    [
                        'content' => $news['content'] ?? '',
                        'author' => $news['author'] ?? 'Unknown',
                        'source' => 'NewsAPI',
                        'category' => 'General',
                        'published_at' => isset($news['publishedAt']) ? Carbon::parse($news['publishedAt'])->format('Y-m-d H:i:s') : now(),
                    ]
                );
            }
        }
    }

    protected function fetchFromGuardianAPI(): void
    {
        $apiKey = env('GUARDIANAPI_KEY');
        $response = Http::get("https://content.guardianapis.com/search?api-key=$apiKey");

        if ($response->successful()) {
            foreach ($response->json()['response']['results'] as $news) {
                Article::updateOrCreate(
                    ['title' => $news['webTitle']],
                    [
                        'content' => $news['fields']['bodyText'] ?? '',
                        'author' => $news['fields']['byline'] ?? 'Unknown',
                        'source' => 'The Guardian',
                        'category' => $news['sectionName'] ?? 'General',
                        'published_at' => isset($news['webPublicationDate']) ? Carbon::parse($news['webPublicationDate'])->format('Y-m-d H:i:s') : now(),
                    ]
                );
            }
        }
    }

    protected function fetchFromNYTimesAPI(): void
    {
        $apiKey = env('NYTIMESAPI_KEY');
        $response = Http::get("https://api.nytimes.com/svc/topstories/v2/home.json?api-key=$apiKey");

        if ($response->successful()) {
            foreach ($response->json()['results'] as $news) {
                Article::updateOrCreate(
                    ['title' => $news['title']],
                    [
                        'content' => $news['abstract'] ?? '',
                        'author' => $news['byline'] ?? 'Unknown',
                        'source' => 'New York Times',
                        'category' => $news['section'] ?? 'General',
                        'published_at' => isset($news['published_date']) ? Carbon::parse($news['published_date'])->format('Y-m-d H:i:s') : now(),
                    ]
                );
            }
        }
    }
}
