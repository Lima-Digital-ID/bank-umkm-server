<?php

return [
    'serverKey' => env('MIDTRANS_SERVER_KEY', null), // Set your Merchant Server Key
    'clientKey' => env('MIDTRANS_CLIENT_KEY', null), // Set your Merchant Server Key
    'isProduction' => env('MIDTRANS_IS_PRODUCTION', null), // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    'isSanitized' => env('MIDTRANS_IS_SANITIZED', null), // Set sanitization on (default)
    'is3ds' => env('MIDTRANS_IS_3DS', null), // Set 3DS transaction for credit card to true
];