<?php

namespace SendMate;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

trait BaseApi
{
    private Client $client;
    private string $apiKey;
    private string $publishableKey;

    public function __construct(string $apiKey, string $publishableKey, bool $isSandbox = false)
    {
        $this->apiKey = $apiKey;
        $this->publishableKey = $publishableKey;
        $this->client = new Client([
            'base_uri' => $isSandbox ? 'https://api-sandbox.sendmate.finance/v1' : 'https://api.sendmate.finance/v1',
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
        return $this->client->get($path, ['query' => $query]);
    }

    /**
     * @throws GuzzleException
     */
    public function post(string $path, array $data = []): ResponseInterface
    {
        return $this->client->post($path, ['json' => $data]);
    }

    /**
     * @throws GuzzleException
     */
    public function put(string $path, array $data = []): ResponseInterface
    {
        return $this->client->put($path, ['json' => $data]);
    }

    /**
     * @throws GuzzleException
     */
    public function delete(string $path): ResponseInterface
    {
        return $this->client->delete($path);
    }
} 


