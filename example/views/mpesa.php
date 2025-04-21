<?php
$title = 'M-Pesa Payment';
$description = 'Make a payment using M-Pesa';
include __DIR__ . '/components/header.php';
?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <form id="mpesaForm" class="space-y-4">
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="tel" id="phone" name="phone" required placeholder="+254XXXXXXXXX"
                   class="form-input block w-full pl-16 pr-3 py-3 text-base rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
            <p class="mt-1 text-sm text-gray-500">Format: +254XXXXXXXXX</p>
        </div>

        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
            <input type="number" id="amount" name="amount" required
                   class="form-input block w-full pl-16 pr-3 py-3 text-base rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <input type="text" id="description" name="description"
                   class="form-input block w-full pl-16 pr-3 py-3 text-base rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
        </div>

        <button type="submit" id="submitButton" class="w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 flex items-center justify-center">
            <span id="buttonText">Initiate M-Pesa Payment</span>
            <svg id="submitLoader" class="animate-spin h-5 w-5 text-white ml-2 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </button>
    </form>

    <div id="status" class="mt-4 hidden">
        <div class="bg-gray-100 p-4 rounded-lg">
            <h3 class="font-medium">Payment Status</h3>
            <div class="mt-2 flex items-center">
                <p id="statusMessage" class="flex-grow"></p>
                <svg id="statusLoader" class="animate-spin h-5 w-5 text-gray-500 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <div class="mt-4">
                <button id="checkStatus" class="text-blue-500 hover:text-blue-600 flex items-center">
                    <span>Check Status</span>
                    <svg id="checkStatusLoader" class="animate-spin h-4 w-4 text-blue-500 ml-1 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="mt-4 hidden">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <h3 class="text-lg font-medium text-green-800">Payment Successful!</h3>
            </div>
            <p id="successDetails" class="mt-2 text-sm text-green-700"></p>
            <div class="mt-4">
                <button id="newPaymentButton" class="w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Initiate New Payment
                </button>
            </div>
        </div>
    </div>

    <!-- Error Message -->
    <div id="errorMessage" class="mt-4 hidden">
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <h3 class="text-lg font-medium text-red-800">Payment Failed</h3>
            </div>
            <p id="errorDetails" class="mt-2 text-sm text-red-700"></p>
            <div class="mt-4">
                <button id="retryPaymentButton" class="w-full bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Try Again
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentReference = null;
let statusCheckInterval = null;

document.getElementById('mpesaForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const submitButton = document.getElementById('submitButton');
    const submitLoader = document.getElementById('submitLoader');
    const buttonText = document.getElementById('buttonText');
    
    // Disable button and show loader
    submitButton.disabled = true;
    submitLoader.classList.remove('hidden');
    buttonText.textContent = 'Initiating Payment...';
    
    const formData = {
        phone: document.getElementById('phone').value,
        amount: document.getElementById('amount').value,
        description: document.getElementById('description').value
    };

    try {
        const response = await fetch('/api/mpesa/stk', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();
        
        if (data.success) {
            currentReference = data.data.reference;
            document.getElementById('status').classList.remove('hidden');
            document.getElementById('statusMessage').textContent = 'Payment initiated. Please check your phone.';
            
            // Start automatic status checking
            startStatusCheck();
        } else {
            showError(data.message || 'Failed to initiate M-Pesa payment');
        }
    } catch (error) {
        showError('An error occurred. Please try again.');
    } finally {
        // Re-enable button and hide loader
        submitButton.disabled = false;
        submitLoader.classList.add('hidden');
        buttonText.textContent = 'Initiate M-Pesa Payment';
    }
});

function startStatusCheck() {
    // Clear any existing interval
    if (statusCheckInterval) {
        clearInterval(statusCheckInterval);
    }
    
    // Start new interval (check every 5 seconds)
    statusCheckInterval = setInterval(checkPaymentStatus, 5000);
}

function stopStatusCheck() {
    if (statusCheckInterval) {
        clearInterval(statusCheckInterval);
        statusCheckInterval = null;
    }
}

function showError(message) {
    stopStatusCheck();
    document.getElementById('status').classList.add('hidden');
    document.getElementById('errorMessage').classList.remove('hidden');
    document.getElementById('errorDetails').textContent = message;
    document.getElementById('mpesaForm').classList.add('hidden');
}

document.getElementById('checkStatus').addEventListener('click', () => {
    const checkStatusLoader = document.getElementById('checkStatusLoader');
    checkStatusLoader.classList.remove('hidden');
    checkPaymentStatus().finally(() => {
        checkStatusLoader.classList.add('hidden');
    });
});

document.getElementById('newPaymentButton').addEventListener('click', () => {
    // Reset form and show it
    document.getElementById('mpesaForm').reset();
    document.getElementById('status').classList.add('hidden');
    document.getElementById('successMessage').classList.add('hidden');
    document.getElementById('errorMessage').classList.add('hidden');
    document.getElementById('mpesaForm').classList.remove('hidden');
});

document.getElementById('retryPaymentButton').addEventListener('click', () => {
    // Reset form and show it
    document.getElementById('mpesaForm').reset();
    document.getElementById('status').classList.add('hidden');
    document.getElementById('successMessage').classList.add('hidden');
    document.getElementById('errorMessage').classList.add('hidden');
    document.getElementById('mpesaForm').classList.remove('hidden');
});

async function checkPaymentStatus() {
    if (!currentReference) return;

    const statusLoader = document.getElementById('statusLoader');
    statusLoader.classList.remove('hidden');

    try {
        const response = await fetch(`/api/mpesa/status/${currentReference}`);
        const data = await response.json();
        
        if (data.success) {
            const status = data.data.status;
            document.getElementById('statusMessage').textContent = `Status: ${status}`;
            
            if (status === 'COMPLETED') {
                stopStatusCheck();
                // Hide the check status button since payment is completed
                document.getElementById('checkStatus').classList.add('hidden');
                
                // Show success message
                document.getElementById('successMessage').classList.remove('hidden');
                document.getElementById('successDetails').textContent = `Payment of KES ${data.data.amount} completed successfully.`;
                
                // Hide the form
                document.getElementById('mpesaForm').classList.add('hidden');
            } else if (status === 'FAILED') {
                showError('Payment failed. Please try again.');
            }
        }
    } catch (error) {
        console.error('Error checking status:', error);
        showError('Error checking status. Please try again.');
    } finally {
        statusLoader.classList.add('hidden');
    }
}
</script>

<?php
include __DIR__ . '/components/footer.php';
?> 