<?php

require_once __DIR__ . '/../vendor/autoload.php';

use SendMate\SendMate;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize the SendMate client
$sendmate = new SendMate(
    $_ENV['SENDMATE_PUBLISHABLE_KEY'],
    $_ENV['SENDMATE_SECRET_KEY'],
    $_ENV['SENDMATE_SANDBOX'] == 'true'
);



