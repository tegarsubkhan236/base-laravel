<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait NewsAPI_Request
{
    /**
     * Send a request to News API
     * @throws GuzzleException
     */
    public function newsRequest($method, $requestUrl, array $queryParams = [])
    {
        $key = '9099d52d0aae48cdb365d8aab32c1984';
        $client = new Client([
            'base_uri' => 'https://newsapi.org/',
        ]);
        $response = $client->request($method, $requestUrl, [
            'query' => $queryParams,
            'headers' => [
                'X-Api-Key' => $key,
                'Accept' => 'application/json'
            ],
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
