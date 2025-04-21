<?php
$content = __FILE__;
require __DIR__ . '/layout.php';
?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 text-center">
    <div class="text-green-500 mb-4">
        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
    </div>
    
    <h2 class="text-2xl font-bold mb-4">Payment Successful!</h2>
    <p class="text-gray-600 mb-6">Your payment was processed successfully.</p>
    
    <?php if (isset($_GET['session_id'])): ?>
        <div class="bg-gray-100 p-4 rounded-lg mb-6">
            <p class="text-sm text-gray-600">Session ID: <?= htmlspecialchars($_GET['session_id']) ?></p>
        </div>
    <?php endif; ?>
    
    <a href="/" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
        Return Home
    </a>
</div> 