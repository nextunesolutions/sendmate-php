<?php

namespace SendMate;

use SendMate\Wallet;
use SendMate\Collection;
use SendMate\Checkout;

class SendMate
{
    private Wallet $wallet;
    private Collection $collection;
    private Checkout $checkout;

    public function __construct(string $apiKey, string $publishableKey, bool $isSandbox = false)
    {
        $this->collection = new Collection($apiKey, $publishableKey, $isSandbox);
        $this->checkout = new Checkout($apiKey, $publishableKey, $isSandbox);
        $this->wallet = new Wallet($apiKey, $publishableKey, $isSandbox);
    }

    public function wallet(): Wallet
    {
        return $this->wallet;
    }

    public function collection(): Collection
    {
        return $this->collection;
    }

    public function checkout(): Checkout
    {
        return $this->checkout;
    }
} 