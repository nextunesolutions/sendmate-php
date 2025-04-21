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
    public function get(string $path, array $query = []): array
    {
        try{
            $response = $this->client->get("/v1{$path}", ['query' => $query]);
            return $this->parseResponse($response);
        } catch (GuzzleException $e) {
            error_log("[SendMate API] Failed to get resource at {$path}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function post(string $path, array $data = []): array
    {
        try{
            $response = $this->client->post("/v1{$path}", ['json' => $data]);
            return $this->parseResponse($response);
        } catch (GuzzleException $e) {
            error_log("[SendMate API] Failed to create resource at {$path}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function put(string $path, array $data = []): array
    {
        try{
            $response = $this->client->put("/v1{$path}", ['json' => $data]);
            return $this->parseResponse($response);
        } catch (GuzzleException $e) {
            error_log("[SendMate API] Failed to update resource at {$path}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function delete(string $path): array
    {
        try{
            $response = $this->client->delete("/v1{$path}");
            return $this->parseResponse($response);
        } catch (GuzzleException $e) {
            error_log("[SendMate API] Failed to delete resource at {$path}: " . $e->getMessage());
            throw $e;
        }
    }


     /**
     * Parse the API response into the specified response type
     * 
     * @param ResponseInterface $response The API response
     * @return mixed
     */
    private function parseResponse(ResponseInterface $response)
    {
        $responseBody = $response->getBody()->getContents();
        $data = json_decode($responseBody, true);
        
        // Log successful response details
        error_log("[SendMate API] Response Status: " . $response->getStatusCode());
        // error_log("[SendMate API] Response Headers: " . json_encode($response->getHeaders()));
        error_log("[SendMate API] Response Body: " . $responseBody);
        
        if (isset($data['success']) && $data['success']) {
            error_log("[SendMate API] Success Response: " . json_encode($data));
        }
        
        return $data;
    }
} 


