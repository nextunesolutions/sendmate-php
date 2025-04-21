<?php

require_once __DIR__ . '/../vendor/autoload.php';

use SendMate\SendMate;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$SENDMATE_SECRET_KEY = $_ENV['SENDMATE_SECRET_KEY'];
$SENDMATE_PUBLISHABLE_KEY = $_ENV['SENDMATE_PUBLISHABLE_KEY'];
$SENDMATE_SANDBOX = $_ENV['SENDMATE_SANDBOX'] === 'true';


// error_log($SENDMATE_SECRET_KEY);
// error_log($SENDMATE_PUBLISHABLE_KEY);
// error_log($SENDMATE_SANDBOX);

// Initialize the SendMate client
$sendmate = new SendMate(
    $_ENV['SENDMATE_SECRET_KEY'],
    $_ENV['SENDMATE_PUBLISHABLE_KEY'],
    $_ENV['SENDMATE_SANDBOX'] === 'true'
);

// Helper function to get JSON response
function getJsonResponse($response) {
    return json_decode($response->getBody()->getContents(), true);
}

// Helper function to format currency
function formatCurrency($amount, $currency) {
    return number_format($amount, 2) . ' ' . $currency;
}



