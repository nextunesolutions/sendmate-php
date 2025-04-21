<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SendMate Payment Demo' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>


    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }
        input[type="number"] {
          -moz-appearance: textfield;
        }
        .form-input {
          border: 1px solid #d1d5db;
          @apply block w-full pl-16 pr-3 py-3 text-base rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">


<nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-indigo-600">SendMate</a>
                </div>
            </div>
        </div>
    </nav>
    

    <main class="flex-grow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">


    <!-- <div class="container mx-auto px-4 py-8 flex-grow">
        <div class="mb-8">
            <h1 class="text-3xl font-bold"><?= $title ?? 'SendMate Payment Demo' ?></h1>
            <?php if (isset($description)): ?>
                <p class="text-gray-600 mt-2"><?= htmlspecialchars($description) ?></p>
            <?php endif; ?>
        </div> -->


                