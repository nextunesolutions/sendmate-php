<?php

namespace SendMate;

use SendMate\Wallet;
use SendMate\Collection;
use SendMate\Checkout;

class SendMate
{
    public Wallet $wallet;
    public Collection $collection;
    public Checkout $checkout;
    public B2C $b2c;

    public function __construct(string $apiKey, string $publishableKey, bool $isSandbox = false)
    {
        $this->collection = new Collection($apiKey, $publishableKey, $isSandbox);
        $this->checkout = new Checkout($apiKey, $publishableKey, $isSandbox);
        $this->wallet = new Wallet($apiKey, $publishableKey, $isSandbox);
        $this->b2c = new B2C($apiKey, $publishableKey, $isSandbox);
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

    public function b2c(): B2C
    {
        return $this->b2c;
    }
} 