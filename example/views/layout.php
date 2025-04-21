<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SendMate Payment Demo' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <header class="mb-8">
            <h1 class="text-3xl font-bold"><?= $title ?? 'SendMate Payment Demo' ?></h1>
            <?php if (isset($description)): ?>
                <p class="text-gray-600 mt-2"><?= htmlspecialchars($description) ?></p>
            <?php endif; ?>
        </header>
        
        <main>
            <?php require $content ?? __DIR__ . '/404.php'; ?>
        </main>
    </div>
</body>
</html> 