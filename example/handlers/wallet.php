<?php

use SendMate\SendMate;

function handleGetWallets(SendMate $sendmate) {
    header('Content-Type: application/json');
    
    try {
        $wallets = $sendmate->wallet()->get_wallets();
        if (!$wallets) {
            echo json_encode([
                'success' => false,
                'message' => 'No wallets found'
            ]);
            return;
        }

        echo json_encode([
            'success' => true,
            'data' => $wallets
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to fetch wallets',
            'error' => $e->getMessage()
        ]);
    }
}

function handleGetWallet(SendMate $sendmate, string $walletId) {
    header('Content-Type: application/json');
    
    try {
        $wallet = $sendmate->wallet()->get_wallet($walletId);
        if (!$wallet) {
            echo json_encode([
                'success' => false,
                'message' => 'Wallet not found'
            ]);
            return;
        }

        echo json_encode([
            'success' => true,
            'data' => $wallet
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to fetch wallet',
            'error' => $e->getMessage()
        ]);
    }
}

function handleSetDefaultWallet(SendMate $sendmate, string $walletId) {
    header('Content-Type: application/json');
    
    try {
        $result = $sendmate->wallet()->set_default_wallet($walletId);
        if (!$result) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to set default wallet'
            ]);
            return;
        }

        // echo json_encode([
        //     'success' => true,
        //     'data' => $result
        // ]);

        // here lets redirect to the wallets page
        header('Location: /wallets/');
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to set default wallet',
            'error' => $e->getMessage()
        ]);
    }
} 