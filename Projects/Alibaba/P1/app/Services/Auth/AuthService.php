<?php

namespace App\Services\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class AuthService
{
    protected $client;

    /**
     * AuthService constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Refresh the access token using the provided refresh token.
     *
     * @param string $refreshToken The refresh token to use for refreshing the access token.
     * @return string|null The new access token, or null if the refresh fails.
     */
    public function refreshToken(string $refreshToken): ?string
    {
        $tokenEndpoint = url('/oauth/token');
        try {
            $response = Http::timeout(300)->asForm()->post($tokenEndpoint, [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id' => 'your_client_id_here',
                    'client_secret' => 'your_client_secret_here',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return $data['access_token'] ?? null;
        } catch (RequestException $e) {
            // Log or handle the error
            return null;
        }
    }
}
