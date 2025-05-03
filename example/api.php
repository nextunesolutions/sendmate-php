<?php

include_once __DIR__ . '/client.php';
include_once __DIR__ . '/handlers/mpesa.php';
include_once __DIR__ . '/handlers/checkout.php';
include_once __DIR__ . '/handlers/wallet.php';
include_once __DIR__ . '/handlers/b2c.php';

use SendMate\SendMate;

function handleApiRoutes(SendMate $sendmate) {
    $request = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];
    
    // Remove query string
    $path = strtok($request, '?');
    
    // API routes
    switch ($path) {
        case '/api/checkout':
            if ($method === 'POST') {
                handleCheckout($sendmate);
            }
            break;
        case '/api/mpesa/stk':
            if ($method === 'POST') {
                handleMpesaStk($sendmate);
            }
            break;
        case (preg_match('/^\/api\/mpesa\/status\/(.+)$/', $path, $matches) ? true : false):
            if ($method === 'GET') {
                handleMpesaStatus($sendmate, $matches[1]);
            }
            break;
        case (preg_match('/^\/api\/sessions\/(.+)$/', $path, $matches) ? true : false):
            if ($method === 'GET') {
                handleSessionStatus($sendmate, $matches[1]);
            }
            break;
        case '/api/wallets':
            if ($method === 'GET') {
                handleGetWallets($sendmate);
            }
            break;
        case (preg_match('/^\/api\/wallets\/([^\/]+)$/', $path, $matches) ? true : false):
            if ($method === 'GET') {
                handleGetWallet($sendmate, $matches[1]);
            }
            break;
        case (preg_match('/^\/api\/wallets\/([^\/]+)\/set-default$/', $path, $matches) ? true : false):
            if ($method === 'POST') {
                handleSetDefaultWallet($sendmate, $matches[1]);
            }
            break;
        case '/api/b2c':
            if ($method === 'POST') {
                handleB2CPayment($sendmate);
            }
            break;
        case (preg_match('/^\/api\/b2c\/status\/(.+)$/', $path, $matches) ? true : false):
            if ($method === 'GET') {
                handleB2CStatus($sendmate, $matches[1]);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'API endpoint not found'
            ]);
            break;
    }
} 