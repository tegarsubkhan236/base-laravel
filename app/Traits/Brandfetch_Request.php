<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait Brandfetch_Request
{
    /**
     * Send a request to Brand Fetch
     */
    public function brandRequest($requestUrl)
    {
        $token = 'sP5k/sRR41Cw3UpfmgOeQalmlvkek9vHZBYVSw65oKM=';
        $client = new Client([
            'base_uri' => 'https://api.brandfetch.io/v2/brands/',
        ]);
        try {
            $response = $client->request('GET', $requestUrl,
                [
                    'headers' => [
                        'Authorization'=> "Bearer $token",
                        'Accept'=> 'application/json'
                    ],
                ]
            );
            return json_decode($response->getBody(),true);
        }catch (GuzzleException $e) {
            return $e;
        }
    }
}
