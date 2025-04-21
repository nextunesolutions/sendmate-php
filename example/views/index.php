<?php
$title = 'SendMate Payment Demo';
$description = 'Choose your preferred payment method';
include __DIR__ . '/components/header.php';
?>

<div id="error" class="hidden bg-red-50 border-l-4 border-red-400 p-4 mb-6">
    <div class="flex">
      <div class="flex-shrink-0">
        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9h2v5H9V9zm0-4h2v2H9V5z" clip-rule="evenodd" />
        </svg>
      </div>
      <div class="ml-3">
        <p id="errorMessage" class="text-sm text-red-700"></p>
      </div>
    </div>
  </div>

  <div class="space-y-6">
    <div class="bg-gray-50 p-4 rounded-md">
      <h3 class="text-lg font-medium text-gray-900 mb-2">Payment Methods</h3>
      <div class="space-y-4 mt-4">
        <a href="/checkout" class="flex items-center justify-between p-4 bg-white border rounded-md hover:bg-gray-50">
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
            <span class="ml-3 font-medium">Card Payment</span>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </a>
        
        <a href="/mpesa" class="flex items-center justify-between p-4 bg-white border rounded-md hover:bg-gray-50">
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            <span class="ml-3 font-medium">M-Pesa Payment</span>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </a>
      </div>
    </div>
  </div>

<?php
include __DIR__ . '/components/footer.php';
?> 