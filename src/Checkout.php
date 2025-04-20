<?php

namespace SendMate;

use SendMate\Request;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Checkout
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws GuzzleException
     */
    public function create(array $data): ResponseInterface
    {
        return $this->request->post('/checkouts', $data);
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $checkoutId): ResponseInterface
    {
        return $this->request->get("/checkouts/{$checkoutId}");
    }

    /**
     * @throws GuzzleException
     */
    public function list(array $query = []): ResponseInterface
    {
        return $this->request->get('/checkouts', $query);
    }

    /**
     * @throws GuzzleException
     */
    public function cancel(string $checkoutId): ResponseInterface
    {
        return $this->request->post("/checkouts/{$checkoutId}/cancel");
    }
} 