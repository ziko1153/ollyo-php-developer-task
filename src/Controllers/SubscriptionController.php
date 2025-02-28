<?php

namespace Ollyo\Task\Controllers;

use Config\PayPal;
use PayPal\Api\Agreement;
use Exception;

class SubscriptionController extends Controller
{
    private static  $plans = [
        'basic' => [
            'name' => 'Basic Plan',
            'description' => 'Monthly Basic Subscription',
            'price' => 29
        ],
        'premium' => [
            'name' => 'Premium Plan',
            'description' => 'Monthly Premium Subscription',
            'price' => 49
        ]
    ];

    public static function showPlans()
    {
        return view('subscription/plans',['plans' => self::$plans]);
    }

    public static function createSubscription($planType)
    {
        if (!isset(self::$plans[$planType])) {
            throw new Exception('Invalid plan selected');
        }

        $planDetails = self::$plans[$planType];

        try {
        
            //TODO: due to lack of  knowledge in paypal recurring system , so i can not implement in details during this time
            // My plan is to 
            //1. Create  a Subscription Plan To Paypal
            //2. 

            $_SESSION['subscription_pending'] = [
                'plan_type' => $planType,
                'plan_details' => $planDetails
            ];

            return redirect('/subscription/success?token='.uniqid());


        } catch (Exception $e) {
            return view('failure', ['message' => $e->getMessage()]);
        }
    }

    public static function handleSuccess($request)
    {
        if (!isset($_SESSION['subscription_pending'])) {
            redirect('/subscription/plans');
        }

        try {
            $token = $request['token']??null;
            $agreement = new Agreement();
            
            $executedAgreement = $agreement->execute($token, PayPal::getApiContext());
            
            $subscriptionData = [
                'agreement_id' => $executedAgreement->getId(),
                'plan_type' => $_SESSION['subscription_pending']['plan_type'],
                'status' => $executedAgreement->getState(),
                'start_date' => $executedAgreement->getStartDate(),
                'plan_details' => $_SESSION['subscription_pending']['plan_details']
            ];

            unset($_SESSION['subscription_pending']);
            
            return view('subscription/success', [
                'subscription' => $subscriptionData
            ]);

        } catch (Exception $e) {
            return view('failure', ['message' => $e->getMessage()]);
        }
    }
}