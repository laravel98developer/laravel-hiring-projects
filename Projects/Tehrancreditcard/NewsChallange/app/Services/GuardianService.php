<?php

namespace App\Services;

use GuzzleHttp\Client;

class GuardianService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {

        $this->client = new Client();
        $this->apiKey = config('services.guardian.key');
    }

    public function fetchNews()
    {
        // Perform the API request to The Guardian
        $response = $this->client->get('https://content.guardianapis.com/search', [
            'query' => [
                'api-key'     => $this->apiKey,
                'show-fields' => 'all',
                'page-size'   => 10,
            ],
        ]);

        // Handle the response (convert JSON to array)
        $data = json_decode($response->getBody()->getContents(), true);

        // Return the news articles data
        return $data['response']['results'] ?? [];
    }
}
