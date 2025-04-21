<?php
$content = __FILE__;
require __DIR__ . '/layout.php';
?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <form id="mpesaForm" class="space-y-4">
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="tel" id="phone" name="phone" required placeholder="+254XXXXXXXXX"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
            <p class="mt-1 text-sm text-gray-500">Format: +254XXXXXXXXX</p>
        </div>

        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
            <input type="number" id="amount" name="amount" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <input type="text" id="description" name="description"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>

        <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Initiate M-Pesa Payment
        </button>
    </form>

    <div id="status" class="mt-4 hidden">
        <div class="bg-gray-100 p-4 rounded-lg">
            <h3 class="font-medium">Payment Status</h3>
            <p id="statusMessage" class="mt-2"></p>
            <div class="mt-4">
                <button id="checkStatus" class="text-blue-500 hover:text-blue-600">
                    Check Status
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentReference = null;

document.getElementById('mpesaForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
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
            checkPaymentStatus();
        } else {
            alert(data.message || 'Failed to initiate M-Pesa payment');
        }
    } catch (error) {
        alert('An error occurred. Please try again.');
    }
});

document.getElementById('checkStatus').addEventListener('click', checkPaymentStatus);

async function checkPaymentStatus() {
    if (!currentReference) return;

    try {
        const response = await fetch(`/api/mpesa/status/${currentReference}`);
        const data = await response.json();
        
        if (data.success) {
            const status = data.data.status;
            document.getElementById('statusMessage').textContent = `Status: ${status}`;
            
            if (status === 'completed') {
                window.location.href = `/mpesa/success?reference=${currentReference}&amount=${data.data.amount}&phone=${data.data.phone_number}`;
            }
        }
    } catch (error) {
        console.error('Error checking status:', error);
    }
}
</script> 