<?php

namespace Ollyo\Task\Controllers;

use Config\PayPal;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use Exception;

class PaymentController extends Controller
{
    public function createPayment($products, $shipping)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $items = [];
        $subtotal = 0;

        foreach ($products as $product) {
            $item = new Item();
            $item->setName($product['name'])
                ->setCurrency('USD')
                ->setQuantity($product['qty'])
                ->setPrice($product['price']);
            
            $items[] = $item;
            $subtotal += $product['price'] * $product['qty'];
        }

        $itemList = new ItemList();
        $itemList->setItems($items);

        $details = new Details();
        $details->setShipping($shipping)
                ->setSubtotal($subtotal);

        $amount = new Amount();
        $amount->setCurrency('USD')
                ->setTotal($subtotal + $shipping)
                ->setDetails($details);

        $invoiceNumber = uniqid();
        
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setItemList($itemList)
                    ->setDescription('Payment for your order')
                    ->setInvoiceNumber($invoiceNumber);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(BASE_URL . '/payment/success')
                    ->setCancelUrl(BASE_URL . '/payment/cancel');

        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);

        try {
            $payment->create(PayPal::getApiContext());

            $_SESSION['pending_order'] = [
                'invoice_number' => $invoiceNumber,
                'products' => $products,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $subtotal + $shipping,
                'date' => date('Y-m-d H:i:s')
            ];
            return $payment;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function success($request)
    {
        // though we don't have any database , so here session using only for recheck valid payment from callback 
        if (!isset($_SESSION['pending_order'])) {
            $_SESSION['message'] = 'Sorry Invalid Payment ,Order Again Please';
            redirect();
        }
    
        $orderDetails = $_SESSION['pending_order'];
        $paymentId = $request['paymentId'] ?? 'N/A';
        $orderDetails['payment_id'] = $paymentId;
    
        unset($_SESSION['pending_order']);
    
        return view('success', [
            'order' => $orderDetails,
            'message' => 'Your payment was processed successfully!'
        ]);
    }

    public static function canceled($request)
    {
        return view('failure', ['message' => 'Payment was cancelled.']);
    }

    public static function failed($request)
    {
        return view('failure', ['message' => $request['message'] ?? 'An error occurred']);
    }
}