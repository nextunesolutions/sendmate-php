<?php

include_once __DIR__ . '/client.php';
include_once __DIR__ . '/api.php';

use SendMate\SendMate;

// Route handling
$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Remove query string
$path = strtok($request, '?');

// Check if it's an API route
if (strpos($path, '/api') === 0) {
    handleApiRoutes($sendmate);
    return;
}

// Regular routes
switch ($path) {
    case '/':
        require __DIR__ . '/views/index.php';
        break;
    case '/checkout':
        require __DIR__ . '/views/checkout.php';
        break;
    case '/mpesa':
        require __DIR__ . '/views/mpesa.php';
        break;
    case '/wallets':
        require __DIR__ . '/views/wallet.php';
        break;
    case (preg_match('/^\/wallets\/(.+)$/', $path, $matches) ? true : false):
        $walletId = $matches[1];
        require __DIR__ . '/views/wallet-detail.php';
        break;
    case '/b2c':
        require __DIR__ . '/views/b2c.php';
        break;
    case (preg_match('/^\/b2c\/status\/(.+)$/', $path, $matches) ? true : false):
        $_GET['reference'] = $matches[1];
        require __DIR__ . '/views/b2c-status.php';
        break;
    case '/success':
        require __DIR__ . '/views/success.php';
        break;
    case '/cancel':
        require __DIR__ . '/views/cancel.php';
        break;
    case '/mpesa/success':
        require __DIR__ . '/views/mpesa-success.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}



