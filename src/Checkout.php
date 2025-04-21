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
        return $this->post('/checkouts', $data);
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $checkoutId): ResponseInterface
    {
        return $this->get("/checkouts/{$checkoutId}");
    }

    /**
     * @throws GuzzleException
     */
    public function list(array $query = []): ResponseInterface
    {
        return $this->get('/checkouts', $query);
    }

    /**
     * @throws GuzzleException
     */
    public function cancel(string $checkoutId): ResponseInterface
    {
        return $this->post("/checkouts/{$checkoutId}/cancel");
    }
} 