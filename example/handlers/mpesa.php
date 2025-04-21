<?php

use SendMate\SendMate;

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

        $response = $sendmate->collection()->mpesaStkPush([
            'amount' => (float)$amount,
            'phone_number' => $phone,
            'description' => $description
        ]);

        
        echo json_encode([
            'success' => true,
            'message' => 'M-Pesa STK push initiated successfully',
            'data' => [
                'reference' => $response['reference'],
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
        $status = $sendmate->collection()->mpesaCheckStatus($reference);
        
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