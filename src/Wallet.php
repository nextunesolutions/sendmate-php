<?php

namespace SendMate;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use SendMate\Traits\BaseApi;

class Wallet
{
    use BaseApi;

    public function __construct(string $apiKey, string $publishableKey, bool $isSandbox = false)
    {
        $this->init_trait($apiKey, $publishableKey, $isSandbox);
    }

    /**
     * Get all wallets for the authenticated user
     *
     * @return array|null
     */
    public function get_wallets(): ?array
    {
        return $this->get('/payments/wallets');
    }

    /**
     * Get a specific wallet by ID
     *
     * @param string $walletId
     * @return array|null
     */
    public function get_wallet(string $walletId): ?array
    {
        return $this->get("/payments/wallets/{$walletId}");
    }

    /**
     * Get transactions for a specific wallet
     *
     * @param string $walletId
     * @param array $params
     * @return array|null
     */
    public function get_wallet_transactions(string $walletId, array $params = []): ?array
    {
        return $this->get("/payments/wallets/{$walletId}/transactions", $params);
    }

    /**
     * Set a wallet as default
     *
     * @param string $walletId
     * @return array|null
     */
    public function set_default_wallet(string $walletId): ?array
    {
        return $this->post("/payments/wallets/{$walletId}/set-default", []);
    }
} 