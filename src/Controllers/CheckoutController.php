<?php

namespace Ollyo\Task\Controllers;

use Exception;


class CheckoutController extends Controller
{

    public static function checkout(array $request, $products, $shippingCost)
    {
        try {
            self::checkValidation($request);

            $controller = new PaymentController();
            $payment = $controller->createPayment($products, $shippingCost);
            
            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    redirect($link->getHref());
                }
            }
        } catch (Exception $e) {
            header('Location: /payment/error?message=' . urlencode($e->getMessage()));
            exit;
        }
    }

    private static  function checkValidation(array $request)
    {
        $errors = [];

        // Name validation
        if (!isset($request['name']) || empty(trim($request['name']))) {
            $errors['name'] = 'Name Field is required';
        } elseif (strlen($request['name']) > 100) {
            $errors['name'] = 'Name must be less than 100 characters';
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', $request['name'])) {
            $errors['name'] = 'Name can only contain letters and spaces';
        }

        // Email validation
        if (!isset($request['email']) || empty(trim($request['email']))) {
            $errors['email'] = 'Email Field is required';
        } elseif (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        // Address validation
        if (!isset($request['address']) || empty(trim($request['address']))) {
            $errors['address'] = 'Address Field is required';
        } elseif (strlen($request['address']) > 200) {
            $errors['address'] = 'Address must be less than 200 characters';
        }

        // City validation
        if (!isset($request['city']) || empty(trim($request['city']))) {
            $errors['city'] = 'City Field is required';
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', $request['city'])) {
            $errors['city'] = 'City can only contain letters and spaces';
        }

        // Postal code validation
        if (!isset($request['post_code']) || empty(trim($request['post_code']))) {
            $errors['post_code'] = 'Post Code is required';
        } elseif (!preg_match('/^[A-Z0-9]{4,10}$/i', $request['post_code'])) {
            $errors['post_code'] = 'Please enter a valid postal code';
        }

        if (count($errors)) {
            $_SESSION['message'] = 'Validation Error!, Please fix Shipping Information';
            (new Controller)->sendValidationError($errors);
        }

        return [
            'name' => htmlspecialchars(trim($request['name'])),
            'email' => filter_var($request['email'], FILTER_SANITIZE_EMAIL),
            'address' => htmlspecialchars(trim($request['address'])),
            'city' => htmlspecialchars(trim($request['city'])),
            'post_code' => strtoupper(trim($request['post_code']))
        ];
    }
}