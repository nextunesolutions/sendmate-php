<?php
$title = 'B2C Payment Status';
$description = 'Track your B2C payment status';
include __DIR__ . '/components/header.php';

$reference = $_GET['reference'] ?? null;
if (!$reference) {
    header('Location: /b2c');
    exit;
}

$status = $sendmate->b2c->status($reference);
?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <?php if ($status): ?>
        <div class="bg-<?php echo $status['status'] === 'COMPLETED' ? 'green' : 'blue'; ?>-50 border border-<?php echo $status['status'] === 'COMPLETED' ? 'green' : 'blue'; ?>-200 rounded-lg p-4">
            <div class="flex items-center">
                <?php if ($status['status'] === 'COMPLETED'): ?>
                    <svg class="h-5 w-5 text-green-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                <?php else: ?>
                    <svg class="h-5 w-5 text-blue-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                <?php endif; ?>
                <h3 class="text-lg font-medium text-<?php echo $status['status'] === 'COMPLETED' ? 'green' : 'blue'; ?>-800">
                    Status: <?php echo $status['status']; ?>
                </h3>
            </div>
            <div class="mt-4 space-y-2">
                <p class="text-sm text-gray-600">
                    <span class="font-medium">Amount:</span> 
                    <?php echo $status['amount']; ?> <?php echo $status['currency']; ?>
                </p>
                <p class="text-sm text-gray-600">
                    <span class="font-medium">Type:</span> 
                    <?php echo $status['type']; ?>
                </p>
                <p class="text-sm text-gray-600">
                    <span class="font-medium">Created:</span> 
                    <?php echo date('Y-m-d H:i:s', strtotime($status['created_at'])); ?>
                </p>
                <p class="text-sm text-gray-600">
                    <span class="font-medium">Last Updated:</span> 
                    <?php echo date('Y-m-d H:i:s', strtotime($status['updated_at'])); ?>
                </p>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-yellow-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <h3 class="text-lg font-medium text-yellow-800">Status Not Found</h3>
            </div>
            <p class="mt-2 text-sm text-yellow-700">
                The payment status could not be retrieved. Please try again later.
            </p>
        </div>
    <?php endif; ?>
    
    <div class="mt-6 text-center">
        <a href="/b2c" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Make Another Payment
        </a>
    </div>
</div>

<script>
    // Auto-refresh status every 5 seconds if not completed
    <?php if ($status && $status['status'] !== 'COMPLETED'): ?>
    setTimeout(() => {
        window.location.reload();
    }, 5000);
    <?php endif; ?>
</script>

<?php
include __DIR__ . '/components/footer.php';
?> 