<?php

include_once __DIR__ . '/client.php';

use SendMate\SendMate;




// Route handling
$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Remove query string
$path = strtok($request, '?');

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
    case '/success':
        require __DIR__ . '/views/success.php';
        break;
    case '/cancel':
        require __DIR__ . '/views/cancel.php';
        break;
    case '/mpesa/success':
        require __DIR__ . '/views/mpesa-success.php';
        break;
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
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}

function handleCheckout(SendMate $sendmate) {
    header('Content-Type: application/json');
    
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $amount = $data['amount'] ?? null;
        $description = $data['description'] ?? '';
        $currency = $data['currency'] ?? 'KES';
        
        if (!$amount) {
            echo json_encode([
                'success' => false,
                'message' => 'Amount is required'
            ]);
            return;
        }

        $session = $sendmate->checkout()->create([
            'amount' => $amount,
            'description' => $description,
            'currency' => $currency,
            'return_url' => (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/success',
            'cancel_url' => (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/cancel'
        ]);

        echo json_encode([
            'success' => true,
            'data' => [
                'session_id' => $session->session_id,
                'url' => $session->url
            ]
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to create checkout session',
            'error' => $e->getMessage()
        ]);
    }
}

function handleMpesaStk(SendMate $sendmate) {
    header('Content-Type: application/json');
    
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $phone = $data['phone'] ?? null;
        $amount = $data['amount'] ?? null;
        $description = $data['description'] ?? 'Payment for services';
        
        if (!$phone) {
            echo json_encode([
                'success' => false,
                'message' => 'Phone number is required'
            ]);
            return;
        }

        if (!$amount) {
            echo json_encode([
                'success' => false,
                'message' => 'Amount is required'
            ]);
            return;
        }

        if (!preg_match('/^\+254\d{9}$/', $phone)) {
            echo json_encode([
                'success' => false,
                'message' => 'Phone number must be in format +254XXXXXXXXX'
            ]);
            return;
        }

        $response = $sendmate->collection()->initiate([
            'amount' => (float)$amount,
            'phone_number' => $phone,
            'description' => $description
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'M-Pesa STK push initiated successfully',
            'data' => [
                'reference' => $response->reference,
                'status' => $response->status
            ]
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to initiate M-Pesa payment',
            'error' => $e->getMessage()
        ]);
    }
}

function handleMpesaStatus(SendMate $sendmate, string $reference) {
    header('Content-Type: application/json');
    
    try {
        $status = $sendmate->collection()->get($reference);
        
        echo json_encode([
            'success' => true,
            'data' => $status
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to check M-Pesa payment status',
            'error' => $e->getMessage()
        ]);
    }
}

function handleSessionStatus(SendMate $sendmate, string $sessionId) {
    header('Content-Type: application/json');
    
    try {
        $status = $sendmate->checkout()->get($sessionId);
        
        echo json_encode([
            'success' => true,
            'data' => $status
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to check session status',
            'error' => $e->getMessage()
        ]);
    }
}

