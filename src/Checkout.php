<?php

namespace SendMate;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use SendMate\Traits\BaseApi;

class Checkout 
{
    use BaseApi;

    public function __construct(string $apiKey, string $publishableKey, bool $isSandbox = false)
    {
        $this->init_trait($apiKey, $publishableKey, $isSandbox);
    }

    /**
     * @throws GuzzleException
     */
    public function create(array $data): ResponseInterface
    {
        try {
            return $this->post('/checkouts', $data);
        } catch (GuzzleException $e) {
            error_log("[SendMate Checkout] Failed to create checkout: " . $e->getMessage());
            error_log("[SendMate Checkout] Request data: " . json_encode($data));
            throw $e;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $checkoutId): ResponseInterface
    {
        try {
            return $this->get("/checkouts/{$checkoutId}");
        } catch (GuzzleException $e) {
            error_log("[SendMate Checkout] Failed to get checkout {$checkoutId}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function list(array $query = []): ResponseInterface
    {
        try {
            return $this->get('/checkouts', $query);
        } catch (GuzzleException $e) {
            error_log("[SendMate Checkout] Failed to list checkouts: " . $e->getMessage());
            error_log("[SendMate Checkout] Query parameters: " . json_encode($query));
            throw $e;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function cancel(string $checkoutId): ResponseInterface
    {
        try {
            return $this->post("/checkouts/{$checkoutId}/cancel");
        } catch (GuzzleException $e) {
            error_log("[SendMate Checkout] Failed to cancel checkout {$checkoutId}: " . $e->getMessage());
            throw $e;
        }
    }
} 