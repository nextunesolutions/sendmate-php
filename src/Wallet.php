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
        try {
            return $this->get('/payments/wallets');
        } catch (GuzzleException $e) {
            error_log("[SendMate Wallet] Failed to get wallets: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get a specific wallet by ID
     * @throws GuzzleException
     */
    public function getWallet(string $walletId): ResponseInterface
    {
        try {
            return $this->get("/payments/wallets/{$walletId}");
        } catch (GuzzleException $e) {
            error_log("[SendMate Wallet] Failed to get wallet {$walletId}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get transactions for a specific wallet
     * @throws GuzzleException
     */
    public function getWalletTransactions(string $walletId, array $params = []): ResponseInterface
    {
        try {
            return $this->get("/payments/wallets/{$walletId}/transactions", $params);
        } catch (GuzzleException $e) {
            error_log("[SendMate Wallet] Failed to get transactions for wallet {$walletId}: " . $e->getMessage());
            error_log("[SendMate Wallet] Query parameters: " . json_encode($params));
            throw $e;
        }
    }

    /**
     * Set a wallet as default
     * @throws GuzzleException
     */
    public function setDefaultWallet(string $walletId): ResponseInterface
    {
        try {
            return $this->post("/payments/wallets/{$walletId}/set-default", []);
        } catch (GuzzleException $e) {
            error_log("[SendMate Wallet] Failed to set wallet {$walletId} as default: " . $e->getMessage());
            throw $e;
        }
    }
} 