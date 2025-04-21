<?php

use SendMate\SendMate;

/**
 * Handles the creation of a new checkout session
 * 
 * @param SendMate $sendmate The SendMate instance
 */
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

        $session = $sendmate->checkout()->create_checkout_session([
            'amount' => $amount,
            'description' => $description,
            'currency' => $currency,
            'return_url' => (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/success',
            'cancel_url' => (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/cancel'
        ]);

        echo json_encode([
            'success' => true,
            'data' => [
                'session_id' => $session['session_id'],
                'url' => $session['url']
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

/**
 * Handles checking the status of a checkout session
 * 
 * @param SendMate $sendmate The SendMate instance
 * @param string $sessionId The session ID to check
 */
function handleSessionStatus(SendMate $sendmate, string $sessionId) {
    header('Content-Type: application/json');
    
    try {
        $status = $sendmate->checkout()->get_checkout_session_status($sessionId);
        
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