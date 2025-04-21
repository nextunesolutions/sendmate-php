<?php
$title = 'Payment Successful';
$description = 'Your payment was processed successfully';
include __DIR__ . '/components/header.php';

include_once __DIR__ . '/../client.php';

try {
    $sessionId = $_GET['session_id'] ?? null;
    if (!$sessionId) {
        throw new Exception('No session ID provided');
    }

    $payment = $sendmate->checkout()->get_checkout_session_status($sessionId);
  
    // Check if payment is truly successful
    if (!isset($payment['completed']) || !$payment['completed'] || (isset($payment['failed']) && $payment['failed'])) {
        throw new Exception('Payment was not completed successfully');
    }
} catch (Exception $e) {
    error_log('Error in success page: ' . $e->getMessage());
    $error = $e->getMessage();
}
?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <?php if (isset($error)): ?>
        <div class="text-center">
            <div class="text-red-500 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold mb-4">Payment Status Error</h2>
            <p class="text-gray-600 mb-6"><?= htmlspecialchars($error) ?></p>
        </div>
    <?php else: ?>
        <div class="text-center">
            <div class="text-green-500 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h2 class="text-2xl font-bold mb-4">Payment Successful!</h2>
            <p class="text-gray-600 mb-6">Your payment was processed successfully.</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Amount Paid:</span>
                    <span class="font-medium text-xl"><?= htmlspecialchars($payment['currency']) ?> <?= htmlspecialchars($payment['amount']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="font-medium text-green-600"><?= htmlspecialchars($payment['status']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Date:</span>
                    <span class="font-medium"><?= date('M d, Y H:i', strtotime($payment['created_at'])) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Reference:</span>
                    <span class="font-medium text-sm"><?= htmlspecialchars($payment['id']) ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="text-center">
        <a href="/" class="inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Return Home
        </a>
    </div>
</div>

<?php include __DIR__ . '/components/footer.php'; ?> 