<?php

namespace SendMate;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use SendMate\Traits\BaseApi;

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
        try {
            return $this->post('/collections', $data);
        } catch (GuzzleException $e) {
            error_log("[SendMate Collection] Failed to initiate collection: " . $e->getMessage());
            error_log("[SendMate Collection] Request data: " . json_encode($data));
            throw $e;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $collectionId): ResponseInterface
    {
        try {
            return $this->get("/collections/{$collectionId}");
        } catch (GuzzleException $e) {
            error_log("[SendMate Collection] Failed to get collection {$collectionId}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function list(array $query = []): ResponseInterface
    {
        try {
            return $this->get('/collections', $query);
        } catch (GuzzleException $e) {
            error_log("[SendMate Collection] Failed to list collections: " . $e->getMessage());
            error_log("[SendMate Collection] Query parameters: " . json_encode($query));
            throw $e;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function cancel(string $collectionId): ResponseInterface
    {
        try {
            return $this->post("/collections/{$collectionId}/cancel");
        } catch (GuzzleException $e) {
            error_log("[SendMate Collection] Failed to cancel collection {$collectionId}: " . $e->getMessage());
            throw $e;
        }
    }
} 