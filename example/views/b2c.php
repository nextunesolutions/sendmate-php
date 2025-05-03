<?php
$title = 'B2C Payment';
$description = 'Make a B2C payment using your wallet';
include __DIR__ . '/components/header.php';

// Get available wallets
$wallets = $sendmate->wallet->get_wallets();
?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <form id="b2cForm" class="space-y-4">
        <div>
            <label for="wallet" class="block text-sm font-medium text-gray-700">Select Wallet</label>
            <select id="wallet" name="wallet_id" required
                    class="form-select block w-full pl-3 pr-10 py-3 text-base rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                <option value="">Choose a wallet</option>
                <?php foreach ($wallets as $wallet): ?>
                <option value="<?php echo $wallet['id']; ?>" data-balance="<?php echo $wallet['balance']; ?>">
                    <?php echo $wallet['currency']['code']; ?> (Balance: <?php echo $wallet['balance']; ?>)
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Recipient Phone Number</label>
            <input type="tel" id="phone" name="phone_number" required placeholder="+254XXXXXXXXX"
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

        <button type="submit" id="submitButton" class="w-full bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 flex items-center justify-center">
            <span id="buttonText">Send Payment</span>
            <svg id="submitLoader" class="animate-spin h-5 w-5 text-white ml-2 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </button>
    </form>

    <!-- Status Message -->
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
document.getElementById('b2cForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const submitButton = document.getElementById('submitButton');
    const submitLoader = document.getElementById('submitLoader');
    const buttonText = document.getElementById('buttonText');
    
    // Disable button and show loader
    submitButton.disabled = true;
    submitLoader.classList.remove('hidden');
    buttonText.textContent = 'Processing Payment...';
    
    const form = e.target;
    const walletSelect = form.querySelector('#wallet');
    const amountInput = form.querySelector('#amount');
    const selectedWallet = walletSelect.options[walletSelect.selectedIndex];
    const walletBalance = parseFloat(selectedWallet.dataset.balance);
    const amount = parseFloat(amountInput.value);

    if (amount > walletBalance) {
        showError('Insufficient wallet balance');
        return;
    }

    try {
        const response = await fetch('/api/b2c', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                wallet_id: form.wallet_id.value,
                phone_number: form.phone_number.value,
                amount: form.amount.value,
                description: form.description.value
            })
        });

        const data = await response.json();
        
        if (data.success) {
            window.location.href = `/b2c/status/${data.data.reference}`;
        } else {
            showError(data.message || 'Failed to process payment');
        }
    } catch (error) {
        showError('An error occurred while processing your request');
    } finally {
        // Re-enable button and hide loader
        submitButton.disabled = false;
        submitLoader.classList.add('hidden');
        buttonText.textContent = 'Send Payment';
    }
});

function showError(message) {
    document.getElementById('errorMessage').classList.remove('hidden');
    document.getElementById('errorDetails').textContent = message;
    document.getElementById('b2cForm').classList.add('hidden');
}

document.getElementById('retryPaymentButton').addEventListener('click', () => {
    // Reset form and show it
    document.getElementById('b2cForm').reset();
    document.getElementById('errorMessage').classList.add('hidden');
    document.getElementById('b2cForm').classList.remove('hidden');
});
</script>

<?php
include __DIR__ . '/components/footer.php';
?> 