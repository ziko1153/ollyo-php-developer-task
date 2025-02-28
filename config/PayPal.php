<?php

namespace Config;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PayPal
{
    private static $apiContext;

    public static function getApiContext()
    {
        if (!self::$apiContext) {
            self::$apiContext = new ApiContext(
                new OAuthTokenCredential(
                    env('CLIENT_ID'),   
                    env('CLIENT_SECRET') 
                )
            );

            self::$apiContext->setConfig([
                'mode' => env('PAYPAL_MODE'),
                'log.LogEnabled' => true,
                'log.FileName' => '../PayPal.log',
                'log.LogLevel' => 'DEBUG'
            ]);
        }

        return self::$apiContext;
    }
}