<?php

namespace SendMate;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use SendMate\BaseApi;
class Collection
{
    use BaseApi;

    public function __construct(string $apiKey, string $publishableKey, bool $isSandbox = false)
    {
        $this->init_trait($apiKey, $publishableKey, $isSandbox);
    }

    /**
     * @throws GuzzleException
     */
    public function initiate(array $data): ResponseInterface
    {
        return $this->post('/collections', $data);
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $collectionId): ResponseInterface
    {
        return $this->get("/collections/{$collectionId}");
    }

    /**
     * @throws GuzzleException
     */
    public function list(array $query = []): ResponseInterface
    {
        return $this->get('/collections', $query);
    }

    /**
     * @throws GuzzleException
     */
    public function cancel(string $collectionId): ResponseInterface
    {
        return $this->post("/collections/{$collectionId}/cancel");
    }
} 