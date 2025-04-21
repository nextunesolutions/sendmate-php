<?php
$content = __FILE__;
require __DIR__ . '/layout.php';
?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 text-center">
    <div class="text-red-500 mb-4">
        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </div>
    
    <h2 class="text-2xl font-bold mb-4">Payment Cancelled</h2>
    <p class="text-gray-600 mb-6">Your payment was cancelled. You can try again if you wish.</p>
    
    <a href="/" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
        Return Home
    </a>
</div> 