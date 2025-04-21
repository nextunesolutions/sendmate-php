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
     * @throws GuzzleException
     */
    public function getWallets(): ResponseInterface
    {
        return $this->get('/payments/wallets');
    }

    /**
     * Get a specific wallet by ID
     * @throws GuzzleException
     */
    public function getWallet(string $walletId): ResponseInterface
    {
        return $this->get("/payments/wallets/{$walletId}");
    }

    /**
     * Get transactions for a specific wallet
     * @throws GuzzleException
     */
    public function getWalletTransactions(string $walletId, array $params = []): ResponseInterface
    {
        return $this->get("/payments/wallets/{$walletId}/transactions", $params);
    }

    /**
     * Set a wallet as default
     * @throws GuzzleException
     */
    public function setDefaultWallet(string $walletId): ResponseInterface
    {
        return $this->post("/payments/wallets/{$walletId}/set-default", []);
    }
} 