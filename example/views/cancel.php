<?php
$title = 'Payment Cancelled';
$description = 'Your payment was cancelled';
include __DIR__ . '/components/header.php';
?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 text-center">
    <div class="text-yellow-500 mb-4">
        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
    </div>
    
    <h2 class="text-2xl font-bold mb-4">Payment Cancelled</h2>
    <p class="text-gray-600 mb-6">Your payment was cancelled. You can try again if you wish.</p>
    
    <a href="/" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
        Return Home
    </a>
</div>

<?php
include __DIR__ . '/components/footer.php';
?> 