<?php
$title = 'Wallet Details';
$description = 'View wallet details and transactions';
include __DIR__ . '/components/header.php';
include_once __DIR__ . '/../client.php';

try {
    $wallet = $sendmate->wallet()->get_wallet($walletId);
    if (!$wallet) {
        header('Location: /wallets');
        exit;
    }
    $title = $wallet['currency']['name'] . ' Wallet';
} catch (Exception $e) {
    error_log('Error fetching wallet details: ' . $e->getMessage());
    header('Location: /wallets');
    exit;
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold"><?= htmlspecialchars($title) ?></h1>
        <a href="/wallets" class="text-blue-600 hover:text-blue-800">← Back to Wallets</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-semibold mb-4">Wallet Information</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Currency</p>
                        <p class="font-medium"><?= htmlspecialchars($wallet['currency']['name']) ?> (<?= htmlspecialchars($wallet['currency']['code']) ?>)</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Balance</p>
                        <p class="font-medium text-2xl"><?= htmlspecialchars($wallet['currency']['symbol'] . $wallet['balance']) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <p class="font-medium">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $wallet['is_default'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                <?= $wallet['is_default'] ? 'Default Wallet' : 'Secondary Wallet' ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
                <?php if (empty($wallet['transactions'])): ?>
                    <p class="text-gray-500">No recent transactions.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($wallet['transactions'] as $transaction): ?>
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
</div>

<?php include __DIR__ . '/components/footer.php'; ?> 