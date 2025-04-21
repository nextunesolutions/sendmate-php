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

        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Proceed to Payment
        </button>
    </form>
</div>

<script>
document.getElementById('checkoutForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
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
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    }
});
</script>

<?php
include __DIR__ . '/components/footer.php';
?> 