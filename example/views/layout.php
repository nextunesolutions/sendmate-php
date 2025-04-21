<?php
// Include header
include __DIR__ . '/components/header.php';
?>

<main>
    <?php if (isset($content)): ?>
        <?php include $content; ?>
    <?php else: ?>
        <?php include __DIR__ . '/404.php'; ?>
    <?php endif; ?>
</main>

<?php
// Include footer
include __DIR__ . '/components/footer.php';
?> 