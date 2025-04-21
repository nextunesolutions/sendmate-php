<?php
$title = 'Card Payment';
$description = 'Make a payment using your card';
include __DIR__ . '/components/header.php';
?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <form id="checkoutForm" class="space-y-4">
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

        <div>
            <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
            <select id="currency" name="currency"
                    class="form-input block w-full pl-16 pr-3 py-3 text-base rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                <option value="KES">KES</option>
                <!-- <option value="USD">USD</option> -->
                <!-- <option value="EUR">EUR</option> -->
            </select>
        </div>

        <button type="submit" id="submitButton" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center justify-center">
            <span id="buttonText">Proceed to Payment</span>
            <svg id="loadingSpinner" class="hidden animate-spin ml-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </button>
    </form>
</div>

<script>
document.getElementById('checkoutForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const submitButton = document.getElementById('submitButton');
    const buttonText = document.getElementById('buttonText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    
    // Disable button and show loading
    submitButton.disabled = true;
    buttonText.textContent = 'Processing...';
    loadingSpinner.classList.remove('hidden');
    
    const formData = {
        amount: document.getElementById('amount').value,
        description: document.getElementById('description').value,
        currency: document.getElementById('currency').value
    };

    try {
        const response = await fetch('/api/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();
        
        if (data.success) {
            window.location.href = data.data.url;
        } else {
            alert(data.message || 'Failed to create checkout session');
            // Reset button state on error
            submitButton.disabled = false;
            buttonText.textContent = 'Proceed to Payment';
            loadingSpinner.classList.add('hidden');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
        // Reset button state on error
        submitButton.disabled = false;
        buttonText.textContent = 'Proceed to Payment';
        loadingSpinner.classList.add('hidden');
    }
});
</script>

<?php
include __DIR__ . '/components/footer.php';
?> 