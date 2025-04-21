<?php

namespace SendMate\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

trait BaseApi
{
    private Client $client;
    private string $apiKey;
    private string $publishableKey;

    public function init_trait(string $apiKey, string $publishableKey, bool $isSandbox = false)
    {
        $base_url = $isSandbox ? 'https://api-sandbox.sendmate.finance' : 'https://api.sendmate.finance';

        error_log($base_url);

        $this->apiKey = $apiKey;
        $this->publishableKey = $publishableKey;
        $this->client = new Client([
            'base_uri' => $base_url,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer ".$apiKey,
                'SENDMATE-PUBLISHABLE-KEY' => $publishableKey
            ]
        ]);
    }
    

    /**
     * @throws GuzzleException
     */
    public function get(string $path, array $query = []): ResponseInterface
    {
        return $this->client->get("/v1{$path}", ['query' => $query]);
    }

    /**
     * @throws GuzzleException
     */
    public function post(string $path, array $data = []): ResponseInterface
    {
        return $this->client->post("/v1{$path}", ['json' => $data]);
    }

    /**
     * @throws GuzzleException
     */
    public function put(string $path, array $data = []): ResponseInterface
    {
        return $this->client->put("/v1{$path}", ['json' => $data]);
    }

    /**
     * @throws GuzzleException
     */
    public function delete(string $path): ResponseInterface
    {
        return $this->client->delete("/v1{$path}");
    }


     /**
     * Parse the API response into the specified response type
     * 
     * @param ResponseInterface $response The API response
     * @return mixed
     */
    private function parseResponse(ResponseInterface $response)
    {
        $data = json_decode($response->getBody()->getContents(), true);
        return $data;
    }
} 


