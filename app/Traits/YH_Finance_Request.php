<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait YH_Finance_Request
{
    /**
     * Send a request to YH Finance
     */
    public function makeRequest($method, $requestUrl, array $queryParams = [])
    {
        $client = new Client([
            'base_uri' => 'https://yh-finance.p.rapidapi.com/',
        ]);
        try {
            $response = $client->request($method, $requestUrl, [
                'query' => $queryParams,
                'headers' => [
                    'x-rapidapi-key' => '26c0251fc0msh95d36c850eb33b2p13a0c7jsn37655b3762c2',
                    'x-rapidapi-host' => 'yh-finance.p.rapidapi.com'
                ],
            ]);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $e;
        }
    }
}
