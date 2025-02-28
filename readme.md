## Installation

## 1. Clone the repository:
```bash
git clone git@github.com:ziko1153/ollyo-php-developer-task.git
cd ollyo-php-developer-task
```
## 2. Install dependencies:
```bash
composer install
```
## 3. Configure environment:
```bash
touch .env
```

## 5. Set this env:
```bash
CLIENT_ID=
CLIENT_SECRET=
WEBHOOK_ID=
PAYPAL_MODE=sandbox
```


## PI Endpoints
### Checkout Flow
- GET /checkout
  
  - Shows checkout page with cart items
  - Response: HTML checkout form
- POST /checkout
  
  - Process checkout and create PayPal payment
  - Required fields:
    - name (string)
    - email (string)
    - address (string)
    - city (string)
    - post_code (string)
  - Response: Redirects to PayPal
### Payment Callbacks
- GET /payment/success
  
  - PayPal success callback
  - Query params: paymentId, token, PayerID
  - Response: Success page with order details
- GET /payment/cancel
  
  - PayPal cancel callback
  - Response: Cancel page with error message
- GET /payment/error
  
  - Payment error handler
  - Query params: message
  - Response: Error page with details
### Subscription Endpoints
- GET /subscription/plans
  
  - Shows available subscription plans
  - Response: HTML page with plan options
- POST /subscription/create
  
  - Creates new subscription
  - Required fields:
    - plan (string: 'basic' or 'premium')
  - Response: Redirects to PayPal
- GET /subscription/success
  
  - Subscription success callback
  - Query params: token
  - Response: Success page with subscription details
### Webhook Endpoint
- POST /paypal/webhook
  - PayPal webhook handler
