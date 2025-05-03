<?php

namespace SendMate;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use SendMate\Traits\BaseApi;

class B2C
{
    use BaseApi;

    public function __construct(string $apiKey, string $publishableKey, bool $isSandbox = false)
    {
        $this->init_trait($apiKey, $publishableKey, $isSandbox);
    }

    /**
     * Initiate an MPESA B2C payment
     * 
     * @param string $phone_number The recipient's phone number
     * @param string $amount The amount to send
     * @param string $transaction_desc Description of the transaction
     * @return array|null Response example:
     * {
     *   "message": "B2C payment initiated successfully",
     *   "reference": "TXN-4CD1B5977C",
     *   "status": "PENDING"
     * }
     */
    public function mpesa(string $phone_number, string $amount, string $transaction_desc = 'MPESA B2C'): ?array
    {
        return $this->post('/payments/b2c/mpesa', [
            'phone_number' => $phone_number,
            'amount' => $amount,
            'description' => $transaction_desc
        ]);
    }

    // public function airtel(string $phone_number, string $amount, string $transaction_desc = 'AIRTEL B2C'): ?array
    // {
    //     return $this->post('/payments/b2c/airtel', [
    //         'phone_number' => $phone_number,
    //         'amount' => $amount,
    //         'description' => $transaction_desc
    //     ]);
    // }

    /**
     * Get the status of a transaction
     * 
     * @param string $reference The transaction reference
     * @return array|null Response example:
     * {
     *   "message": "Transaction status retrieved successfully",
     *   "status": "COMPLETED",
     *   "amount": 10,
     *   "currency": "KES",
     *   "type": "DEBIT",
     *   "created_at": "2025-05-03T09:53:37.352633Z",
     *   "updated_at": "2025-05-03T09:53:40.177699Z"
     * }
     */
    public function status(string $reference): ?array
    {
        return $this->post("/payments/transactions/status", [
            'reference' => $reference
        ]);
    }

    public function details(string $reference): ?array
    {
        return $this->get("/payments/transactions/{$reference}");
    }



}
