<?php
$content = __FILE__;
require __DIR__ . '/layout.php';
?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Card Payment -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Card Payment</h2>
        <p class="text-gray-600 mb-4">Make a payment using your card</p>
        <a href="/checkout" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Pay with Card
        </a>
    </div>

    <!-- M-Pesa Payment -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">M-Pesa Payment</h2>
        <p class="text-gray-600 mb-4">Make a payment using M-Pesa</p>
        <a href="/mpesa" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Pay with M-Pesa
        </a>
    </div>
</div> 