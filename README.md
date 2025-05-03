# SendMate PHP SDK

The official PHP SDK for the SendMate API, providing a simple way to integrate payment processing and wallet management into your PHP applications.

## Installation

You can install the package via Composer:

```bash
composer require sendmate/sendmate-php
```

## Requirements

- PHP 8.1 or higher
- Composer

## Configuration

### Environment Setup

Create a `.env` file in your project root with the following variables:

```env
SENDMATE_PUBLISHABLE_KEY=your_publishable_key
SENDMATE_SECRET_KEY=SK-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
SENDMATE_SANDBOX=true
```

### Client Initialization

```php
require_once __DIR__ . '/vendor/autoload.php';

use SendMate\SendMate;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize the SendMate client
$sendmate = new SendMate(
    $_ENV['SENDMATE_SECRET_KEY'],
    $_ENV['SENDMATE_PUBLISHABLE_KEY'],
    $_ENV['SENDMATE_SANDBOX'] === 'true'
);
```

## Features

### 1. Checkout Sessions

The SDK provides functionality to create and manage checkout sessions for payments.

#### Creating a Checkout Session

```php
$session = $sendmate->checkout()->create_checkout_session([
    'amount' => 1000,
    'description' => 'Payment for services',
    'currency' => 'KES',
    'return_url' => 'https://your-domain.com/success',
    'cancel_url' => 'https://your-domain.com/cancel'
]);
```

Response:
```json
{
    "success": true,
    "data": {
        "session_id": "session_123",
        "url": "https://checkout.sendmate.com/session_123"
    }
}
```

#### Checking Session Status

```php
$status = $sendmate->checkout()->get_checkout_session_status('session_123');
```

### 2. M-Pesa Integration

The SDK supports M-Pesa STK Push payments for Kenyan mobile money transactions.

#### Initiating M-Pesa Payment

```php
$response = $sendmate->collection()->mpesaStkPush([
    'amount' => 1000,
    'phone_number' => '+254712345678',
    'description' => 'Payment for services'
]);
```

Response:
```json
{
    "success": true,
    "message": "M-Pesa STK push initiated successfully",
    "data": {
        "reference": "MPESA_REF_123"
    }
}
```

#### Checking M-Pesa Payment Status

```php
$status = $sendmate->collection()->mpesaCheckStatus('MPESA_REF_123');
```

### 3. B2C Payments

The SDK supports B2C (Business to Consumer) payments, allowing you to send money to mobile numbers.

#### Initiating B2C Payment

```php
$response = $sendmate->b2c->mpesa(
    '+254712345678',  // Recipient's phone number
    '1000',          // Amount to send
    'Salary payment' // Transaction description
);
```

Response:
```json
{
    "message": "B2C payment initiated successfully",
    "reference": "TXN-4CD1B5977C",
    "status": "PENDING"
}
```

#### Checking B2C Transaction Status

```php
$status = $sendmate->b2c->status('TXN-4CD1B5977C');
```

Response:
```json
{
    "message": "Transaction status retrieved successfully",
    "status": "COMPLETED",
    "amount": 1000,
    "currency": "KES",
    "type": "DEBIT",
    "created_at": "2025-05-03T09:53:37.352633Z",
    "updated_at": "2025-05-03T09:53:40.177699Z"
}
```

#### Getting Transaction Details

```php
$details = $sendmate->b2c->details('TXN-4CD1B5977C');
```

#### B2C Payment Flow

1. Check wallet balance before initiating payment
2. Initiate B2C payment with recipient details
3. Monitor transaction status
4. Handle success/failure scenarios

Example with error handling:
```php
try {
    // Check wallet balance first
    $wallet = $sendmate->wallet->get_wallet('wallet_id');
    if ($wallet['balance'] < $amount) {
        throw new Exception('Insufficient wallet balance');
    }

    // Initiate B2C payment
    $response = $sendmate->b2c->mpesa(
        $phone_number,
        $amount,
        $description
    );

    // Store transaction reference for tracking
    $reference = $response['reference'];

    // Check status after a delay
    $status = $sendmate->b2c->status($reference);
    
} catch (Exception $e) {
    // Handle error
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
```

## Error Handling

All API calls should be wrapped in try-catch blocks to handle potential errors:

```php
try {
    $response = $sendmate->checkout()->create_checkout_session($data);
    // Handle success
} catch (Exception $e) {
    // Handle error
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to create checkout session',
        'error' => $e->getMessage()
    ]);
}
```

## Helper Functions

The SDK includes some utility functions:

```php
// Get JSON response from Guzzle response
function getJsonResponse($response) {
    return json_decode($response->getBody()->getContents(), true);
}

// Format currency amount
function formatCurrency($amount, $currency) {
    return number_format($amount, 2) . ' ' . $currency;
}
```

## Security Considerations

1. Always store your API keys in environment variables
2. Use HTTPS for all API communications
3. Validate all user input before processing
4. Implement proper error handling
5. Use the sandbox environment for testing

<!-- ## Testing

Run the test suite:

```bash
composer test
``` -->

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details. 