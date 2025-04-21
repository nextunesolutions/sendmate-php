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
     * Initiate an M-Pesa STK Push payment
     * 
     * @param array $data The payment data containing phone number, amount, etc.
     * @return array The response from the API
     * @throws GuzzleException
     */
    public function mpesaStkPush(array $data)
    {
        try {
            $response = $this->post('/payments/mpesa/stkpush', $data);
            return  $this->parseResponse($response);
        } catch (GuzzleException $e) {
            error_log("[SendMate Collection] Failed to initiate M-Pesa STK Push: " . $e->getMessage());
            error_log("[SendMate Collection] Request data: " . json_encode($data));
            throw $e;
        }
    }

    /**
     * Check the status of an M-Pesa transaction
     * 
     * @param string $reference The transaction reference
     * @return array The response from the API
     * @throws GuzzleException
     */
    public function mpesaCheckStatus(string $reference)
    {
        try {
            $response = $this->get("/payments/mpesa/check-transaction-status/{$reference}");
            return $this->parseResponse($response);
        } catch (GuzzleException $e) {
            error_log("[SendMate Collection] Failed to check M-Pesa status for reference {$reference}: " . $e->getMessage());
            throw $e;
        }
    }

   
} 