<?php

use Ollyo\Task\Routes;
use Ollyo\Task\Controllers\PaymentController;
use Ollyo\Task\Controllers\WebhookController;
use Ollyo\Task\Controllers\CheckoutController;
use Ollyo\Task\Controllers\SubscriptionController;

session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helper.php';

define('BASE_PATH', dirname(__FILE__));
define('BASE_URL', baseUrl());
$products = [
    [
        'name' => 'Minimalist Leather Backpack',
        'image' => BASE_URL . '/resources/images/backpack.webp',
        'qty' => 1,
        'price' => 120,
    ],
    [
        'name' => 'Wireless Noise-Canceling Headphones',
        'image' => BASE_URL . '/resources/images/headphone.jpg',
        'qty' => 1,
        'price' => 250,
    ],
    [
        'name' => 'Smart Fitness Watch',
        'image' => BASE_URL . '/resources/images/watch.webp', 
        'qty' => 1,
        'price' => 199,
    ],
    [
        'name' => 'Portable Bluetooth Speaker',
        'image' => BASE_URL . '/resources/images/speaker.webp',
        'qty' => 1,
        'price' => 89,
    ],
];
$shippingCost = 10;

$data = [
    'products' => $products,
    'shipping_cost' => $shippingCost,
    'address' => [
        'name' => '',
        'email' => 'sherlock@example.com',
        'address' => '221B Baker Street, London, England',
        'city' => '',
        'post_code' => 'NW16XE',
    ]
];

Routes::get('/', function () {
    return view('home', []);
});

Routes::get('/checkout', function () use ($data) {
    return view('checkout', $data);
});

Routes::post('/checkout', function ($request) use ($products, $shippingCost) {
    CheckoutController::checkout($request, $products, $shippingCost);
});

Routes::get('/subscription/plans', function () {
    SubscriptionController::showPlans();
});

Routes::post('/subscription/create', function ($request) {

    SubscriptionController::createSubscription($request['plan']);
});

Routes::get('/subscription/success', function ($request) {
    SubscriptionController::handleSuccess($request);
});

Routes::get('/payment/success', function ($request) {
    PaymentController::success($request);
});

Routes::get('/payment/cancel', function ($request) {
    PaymentController::canceled($request);
});

Routes::get('/payment/error', function ($request) {
    PaymentController::failed($request);
});

Routes::post('/paypal/webhook', function ($request) {
    $headers = getallheaders();
    $payload = file_get_contents('php://input');

    $controller = new WebhookController();
    if (!$controller->handleWebhook($headers, $payload)) {
        http_response_code(500);
        echo 'Webhook handling failed';
        exit;
    }

    http_response_code(200);
    echo 'Webhook processed successfully';
    exit;
});

// Register thank you & payment failed routes with corresponding views here.

$route = Routes::getInstance();
$route->dispatch();
?>