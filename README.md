# SendMate PHP SDK

The official PHP SDK for the SendMate API, providing a simple way to integrate payment processing and wallet management into your PHP applications.

## Installation

You can install the package via Composer:

```bash
composer require sendmate/php-sdk
```

## Requirements

- PHP 8.1 or higher
- Composer

## Usage

### Basic Setup

```php
require_once __DIR__ . '/vendor/autoload.php';

use SendMate\SendMate;

// Initialize the client
$sendmate = new SendMate(
    'your-api-key',
    'your-api-secret',
    'https://api.sendmate.com' // Optional, defaults to production URL
);
```

### Environment Variables

Create a `.env` file in your project root:

```env
SENDMATE_API_KEY=your-api-key
SENDMATE_API_SECRET=your-api-secret
SENDMATE_BASE_URL=https://api.sendmate.com
```

### Wallet Operations

```php
// Create a wallet
$response = $sendmate->wallet()->create([
    'name' => 'Test Wallet',
    'currency' => 'KES',
    'type' => 'personal'
]);

// Get wallet details
$response = $sendmate->wallet()->get('wallet-id');

// List wallets
$response = $sendmate->wallet()->list();
```

### Collection Operations

```php
// Initiate a collection
$response = $sendmate->collection()->initiate([
    'amount' => 1000,
    'currency' => 'KES',
    'description' => 'Test Collection',
    'callback_url' => 'https://your-domain.com/callback'
]);

// Get collection details
$response = $sendmate->collection()->get('collection-id');

// List collections
$response = $sendmate->collection()->list();
```

### Checkout Operations

```php
// Create a checkout
$response = $sendmate->checkout()->create([
    'amount' => 1000,
    'currency' => 'KES',
    'description' => 'Test Checkout',
    'success_url' => 'https://your-domain.com/success',
    'cancel_url' => 'https://your-domain.com/cancel'
]);

// Get checkout details
$response = $sendmate->checkout()->get('checkout-id');

// List checkouts
$response = $sendmate->checkout()->list();
```

## Error Handling

All methods throw exceptions when errors occur. You should wrap your API calls in try-catch blocks:

```php
try {
    $response = $sendmate->wallet()->create($data);
    // Handle success
} catch (Exception $e) {
    // Handle error
    echo "Error: " . $e->getMessage();
}
```

## Testing

Run the test suite:

```bash
composer test
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details. 