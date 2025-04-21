<?php

namespace SendMate;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use SendMate\Traits\BaseApi;

/**
 * Class Checkout
 * 
 * Handles all checkout-related operations including session creation, retrieval, and status verification.
 * 
 * @package SendMate
 */
class Checkout 
{
    use BaseApi;

    /**
     * Initialize the Checkout class with API credentials
     *
     * @param string $apiKey The API key for authentication
     * @param string $publishableKey The publishable key for client-side operations
     * @param bool $isSandbox Whether to use sandbox environment
     */
    public function __construct(string $apiKey, string $publishableKey, bool $isSandbox = false)
    {
        $this->init_trait($apiKey, $publishableKey, $isSandbox);
    }

    /**
     * Create a new checkout session
     *
     * @param array $data The checkout session data
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function create_checkout_session(array $data): ResponseInterface
    {
        try {
            return $this->post('/payments/checkout', $data);
        } catch (GuzzleException $e) {
            error_log("[SendMate Checkout] Failed to create checkout session: " . $e->getMessage());
            error_log("[SendMate Checkout] Request data: " . json_encode($data));
            throw $e;
        }
    }

    /**
     * Get all checkout sessions
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function get_sessions(): ResponseInterface
    {
        try {
            return $this->get('/payments/sessions');
        } catch (GuzzleException $e) {
            error_log("[SendMate Checkout] Failed to get checkout sessions: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get a specific checkout session by ID
     *
     * @param string $session_id The checkout session ID
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function get_checkout_session(string $session_id): ResponseInterface
    {
        try {
            return $this->get("/payments/checkout/{$session_id}");
        } catch (GuzzleException $e) {
            error_log("[SendMate Checkout] Failed to get checkout session {$session_id}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get the status of a specific checkout session
     *
     * @param string $session_id The checkout session ID
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function get_checkout_session_status(string $session_id): ResponseInterface
    {
        try {
            return $this->get("/payments/checkout/{$session_id}/verify");
        } catch (GuzzleException $e) {
            error_log("[SendMate Checkout] Failed to get checkout session status {$session_id}: " . $e->getMessage());
            throw $e;
        }
    }
} 