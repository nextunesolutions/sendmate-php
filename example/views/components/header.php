<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SendMate Payment Demo' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="/" class="text-2xl font-bold text-blue-600">SendMate</a>
                <nav>
                    <ul class="flex space-x-4">
                        <li><a href="/" class="text-gray-600 hover:text-blue-600">Home</a></li>
                        <li><a href="/checkout" class="text-gray-600 hover:text-blue-600">Card Payment</a></li>
                        <li><a href="/mpesa" class="text-gray-600 hover:text-blue-600">M-Pesa</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header> -->

    <div class="container mx-auto px-4 py-8 flex-grow">
        <div class="mb-8">
            <h1 class="text-3xl font-bold"><?= $title ?? 'SendMate Payment Demo' ?></h1>
            <?php if (isset($description)): ?>
                <p class="text-gray-600 mt-2"><?= htmlspecialchars($description) ?></p>
            <?php endif; ?>
        </div>


                