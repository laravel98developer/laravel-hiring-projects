<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class NewsAPIService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        // Initialize the HTTP client and API key
        $this->client = new Client();
        $this->apiKey = config('services.newsapi.key');
    }

    public function fetchNews()
    {
        // Perform the API request
        $response = $this->client->get('https://newsapi.org/v2/top-headlines', [
            'query' => [
                'apiKey'  => $this->apiKey,
                'country' => 'us',
            ],
        ]);

        // Handle the response (convert JSON to array)
        $newsData = json_decode($response->getBody()->getContents(), true);

        // Return the data or process it further
        return $newsData['articles'] ?? [];
    }
}