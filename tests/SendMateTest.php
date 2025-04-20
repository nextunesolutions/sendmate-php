<?php

namespace SendMate\Tests;

use PHPUnit\Framework\TestCase;
use SendMate\SendMate;
use SendMate\Request\Request;
use SendMate\Wallet\Wallet;
use SendMate\Collection\Collection;
use SendMate\Checkout\Checkout;

class SendMateTest extends TestCase
{
    private SendMate $sendmate;

    protected function setUp(): void
    {
        $this->sendmate = new SendMate(
            'test-api-key',
            'test-api-secret',
            'https://api.test.sendmate.com'
        );
    }

    public function testWalletInstance()
    {
        $this->assertInstanceOf(Wallet::class, $this->sendmate->wallet());
    }

    public function testCollectionInstance()
    {
        $this->assertInstanceOf(Collection::class, $this->sendmate->collection());
    }

    public function testCheckoutInstance()
    {
        $this->assertInstanceOf(Checkout::class, $this->sendmate->checkout());
    }
} 