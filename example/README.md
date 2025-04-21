# SendMate PHP SDK Example

This is an example application demonstrating how to use the SendMate PHP SDK for processing payments.

## Features

- Card payments
- M-Pesa payments
- Payment status tracking
- Success and cancel callbacks

## Requirements

- PHP 7.4 or higher
- Composer
- Web server (Apache/Nginx)
- SendMate API credentials

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   ```
3. Copy `.env.example` to `.env` and fill in your SendMate API credentials:
   ```
   SENDMATE_API_KEY=your_api_key
   SENDMATE_PUBLISHABLE_KEY=your_publishable_key
   SENDMATE_SANDBOX=true
   ```

## Usage

1. Start your web server
2. Navigate to the example directory in your browser
3. Choose a payment method:
   - Card Payment: Enter amount and proceed to payment
   - M-Pesa: Enter phone number and amount to initiate STK push

## Directory Structure

```
example/
├── index.php          # Main entry point
├── views/             # View templates
│   ├── layout.php     # Base layout template
│   ├── index.php      # Home page
│   ├── checkout.php   # Card payment form
│   ├── mpesa.php      # M-Pesa payment form
│   ├── success.php    # Success page for card payments
│   ├── mpesa-success.php # Success page for M-Pesa
│   ├── cancel.php     # Cancel page
│   └── 404.php        # Not found page
└── README.md          # This file
```

## API Endpoints

- `POST /api/checkout` - Create a card payment checkout session
- `POST /api/mpesa/stk` - Initiate M-Pesa STK push
- `GET /api/mpesa/status/:reference` - Check M-Pesa payment status
- `GET /api/sessions/:sessionId` - Check card payment session status

## Security

- All API endpoints are protected with proper error handling
- Input validation is performed on all user inputs
- Sensitive data is properly escaped in views
- API credentials are stored in environment variables

## Notes

- The example uses TailwindCSS for styling
- All forms include proper validation
- The application follows PHP best practices
- Error handling is implemented throughout 