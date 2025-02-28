<?php

namespace Ollyo\Task\Controllers;

use Config\PayPal;
use PayPal\Api\VerifyWebhookSignature;
use Exception;

class WebhookController extends Controller
{
    public function handleWebhook($headers, $payload)
    {
        try {
            $this->verifyWebhookSignature($headers, $payload);
            
            $event = json_decode($payload, true);
            
            switch ($event['event_type']) {
                case 'PAYMENT.CAPTURE.COMPLETED':
                    $this->handlePaymentCompleted($event);
                    break;
                    
                case 'PAYMENT.DECLINED.DENIED':
                    $this->handlePaymentDenied($event);
                    break;
                    
            }
            
            return true;
        } catch (Exception $e) {
            error_log('PayPal Webhook Error: ' . $e->getMessage());
            return false;
        }
    }
    
    private function verifyWebhookSignature($headers, $payload)
    {
        $signatureVerification = new VerifyWebhookSignature();
        $signatureVerification->setAuthAlgo($headers['PAYPAL-AUTH-ALGO']);
        $signatureVerification->setTransmissionId($headers['PAYPAL-TRANSMISSION-ID']);
        $signatureVerification->setCertUrl($headers['PAYPAL-CERT-URL']);
        $signatureVerification->setWebhookId(env('WEBHOOK_ID'));
        $signatureVerification->setTransmissionSig($headers['PAYPAL-TRANSMISSION-SIG']);
        $signatureVerification->setTransmissionTime($headers['PAYPAL-TRANSMISSION-TIME']);
        
        $signatureVerification->setRequestBody($payload);
        $response = $signatureVerification->post(PayPal::getApiContext());
        
        if ($response->getVerificationStatus() !== 'SUCCESS') {
            throw new Exception('Webhook signature verification failed');
        }
    }
    
    private function handlePaymentCompleted($event)
    {
        $transactionId = $event['resource']['id'];
        $amount = $event['resource']['amount']['total'];
        
        // TODO: Update  database

        // TODO: Send confirmation email
        
    }
    
    private function handlePaymentDenied($event)
    {
        // TODO: Handle denied payment
    }
    
}