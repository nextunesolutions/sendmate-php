<?php

use SendMate\SendMate;

function handleB2CPayment(SendMate $sendmate) {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['phone_number']) || !isset($data['amount']) || !isset($data['wallet_id'])) {
            throw new Exception('Missing required fields');
        }

        // Check wallet balance first
        $wallet = $sendmate->wallet->get_wallet($data['wallet_id']);
        if (!$wallet) {
            throw new Exception('Wallet not found');
        }

        if ($wallet['balance'] < $data['amount']) {
            throw new Exception('Insufficient wallet balance');
        }

        // Initiate B2C payment
        $response = $sendmate->b2c->mpesa(
            $data['phone_number'],
            $data['amount'],
            $data['description'] ?? 'B2C Payment'
        );

        if (!$response) {
            throw new Exception('Failed to initiate B2C payment');
        }

        // Store transaction details in session for tracking
        $_SESSION['b2c_transaction'] = [
            'reference' => $response['reference'],
            'amount' => $data['amount'],
            'phone' => $data['phone_number'],
            'wallet_id' => $data['wallet_id']
        ];

        echo json_encode([
            'success' => true,
            'message' => 'B2C payment initiated successfully',
            'data' => $response
        ]);

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

function handleB2CStatus(SendMate $sendmate, string $reference) {
    try {
        $status = $sendmate->b2c->status($reference);
        
        if (!$status) {
            throw new Exception('Failed to get transaction status');
        }

        echo json_encode([
            'success' => true,
            'data' => $status
        ]);

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} 