<?php

require_once __DIR__ . '/../vendor/autoload.php';

use SendMate\SendMate;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize the SendMate client
$sendmate = new SendMate(
    $_ENV['SENDMATE_API_KEY'],
    $_ENV['SENDMATE_API_SECRET'],
    $_ENV['SENDMATE_BASE_URL'] ?? 'https://api.sendmate.com'
);

// Example: Create a wallet
try {
    $response = $sendmate->wallet()->create([
        'name' => 'Test Wallet',
        'currency' => 'KES',
        'type' => 'personal'
    ]);
    
    $wallet = json_decode($response->getBody(), true);
    echo "Created wallet: " . $wallet['id'] . "\n";
} catch (Exception $e) {
    echo "Error creating wallet: " . $e->getMessage() . "\n";
}

// Example: Create a collection
try {
    $response = $sendmate->collection()->initiate([
        'amount' => 1000,
        'currency' => 'KES',
        'description' => 'Test Collection',
        'callback_url' => 'https://your-domain.com/callback'
    ]);
    
    $collection = json_decode($response->getBody(), true);
    echo "Created collection: " . $collection['id'] . "\n";
} catch (Exception $e) {
    echo "Error creating collection: " . $e->getMessage() . "\n";
}

// Example: Create a checkout
try {
    $response = $sendmate->checkout()->create([
        'amount' => 1000,
        'currency' => 'KES',
        'description' => 'Test Checkout',
        'success_url' => 'https://your-domain.com/success',
        'cancel_url' => 'https://your-domain.com/cancel'
    ]);
    
    $checkout = json_decode($response->getBody(), true);
    echo "Created checkout: " . $checkout['id'] . "\n";
} catch (Exception $e) {
    echo "Error creating checkout: " . $e->getMessage() . "\n";
} 