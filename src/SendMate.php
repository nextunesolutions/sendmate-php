<?php

namespace SendMate;

use SendMate\Wallet\Wallet;
use SendMate\Collection\Collection;
use SendMate\Checkout\Checkout;
use SendMate\Request\Request;

class SendMate
{
    private Request $request;
    private Wallet $wallet;
    private Collection $collection;
    private Checkout $checkout;

    public function __construct(string $apiKey, string $publishableKey, string $baseUrl = 'https://api.sendmate.com')
    {
        $this->request = new Request($apiKey, $publishableKey, $baseUrl);
        $this->wallet = new Wallet($this->request);
        $this->collection = new Collection($this->request);
        $this->checkout = new Checkout($this->request);
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