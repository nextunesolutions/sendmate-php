<?php
$title = 'My Wallets';
$description = 'View and manage your wallets';
include __DIR__ . '/components/header.php';
include_once __DIR__ . '/../client.php';
try {
    $wallets = $sendmate->wallet->get_wallets();
    if (!$wallets) {
        $wallets = [];
    }

    $default_wallet = array_filter($wallets, function($wallet) {
        return $wallet['is_default'];
    });
    $default_wallet = reset($default_wallet);

    $transactions = [];
    if ($default_wallet) {
        $transactions_response = $sendmate->wallet->get_wallet_transactions(
            $default_wallet['id'],
            ['per_page' => 10, 'page' => 1]
        );
        $transactions = $transactions_response['results'] ?? [];
    }
} catch (Exception $e) {
    error_log('Error fetching wallets: ' . $e->getMessage());
    $wallets = [];
    $transactions = [];
}
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8"><?= htmlspecialchars($title) ?></h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Wallets List -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Your Wallets</h2>
            <?php if (empty($wallets)): ?>
                <p class="text-gray-500">No wallets found.</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($wallets as $wallet): ?>
                        <div class="border rounded-lg p-4 <?= $wallet['is_default'] ? 'border-blue-500 bg-blue-50' : 'border-gray-200' ?>">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-medium"><?= htmlspecialchars($wallet['currency']['name']) ?></h3>
                                    <p class="text-sm text-gray-500">Balance: <?= htmlspecialchars($wallet['currency']['symbol'] . $wallet['balance']) ?></p>
                                </div>
                                <div class="flex space-x-2">
                                    <?php if (!$wallet['is_default']): ?>
                                        <form action="/api/wallets/<?= htmlspecialchars($wallet['id']) ?>/set-default" method="POST" class="inline">
                                            <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm">Set as Default</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-green-600 text-sm">Default</span>
                                    <?php endif; ?>
                                    <a href="/wallets/<?= htmlspecialchars($wallet['id']) ?>" class="text-blue-600 hover:text-blue-800 text-sm">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Recent Transactions</h2>
            <?php if (empty($transactions)): ?>
                <p class="text-gray-500">No recent transactions.</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($transactions as $transaction): ?>
                        <div class="border rounded-lg p-4 border-gray-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-medium"><?= htmlspecialchars($transaction['description']) ?></h3>
                                    <p class="text-sm text-gray-500">
                                        <?= htmlspecialchars($transaction['type']) ?>: 
                                        <?= htmlspecialchars($transaction['currency']['symbol'] . $transaction['amount']) ?>
                                    </p>
                                </div>
                                <span class="text-sm <?= $transaction['status'] === 'COMPLETED' ? 'text-green-600' : 'text-yellow-600' ?>">
                                    <?= htmlspecialchars($transaction['status']) ?>
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                <?= date('M d, Y H:i', strtotime($transaction['created_at'])) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/components/footer.php'; ?> 