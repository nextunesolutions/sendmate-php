<?php

namespace SendMate;

use SendMate\Request;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Collection
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws GuzzleException
     */
    public function initiate(array $data): ResponseInterface
    {
        return $this->request->post('/collections', $data);
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $collectionId): ResponseInterface
    {
        return $this->request->get("/collections/{$collectionId}");
    }

    /**
     * @throws GuzzleException
     */
    public function list(array $query = []): ResponseInterface
    {
        return $this->request->get('/collections', $query);
    }

    /**
     * @throws GuzzleException
     */
    public function cancel(string $collectionId): ResponseInterface
    {
        return $this->request->post("/collections/{$collectionId}/cancel");
    }
} 