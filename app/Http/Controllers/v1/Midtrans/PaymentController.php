<?php

namespace App\Http\Controllers\v1\Midtrans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Configurations
use App\Http\Controllers\Midtrans\Config;

// Midtrans API Resources
use App\Http\Controllers\Midtrans\Transaction;

// Plumbing
use App\Http\Controllers\Midtrans\ApiRequestor;
use App\Http\Controllers\Midtrans\SnapApiRequestor;
use App\Http\Controllers\Midtrans\Notification;
use App\Http\Controllers\Midtrans\CoreApi;
use App\Http\Controllers\Midtrans\Snap;

// Sanitization
use App\Http\Controllers\Midtrans\Sanitizer;




class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    //
    public function getSnapToken(Request $req){

        $item_list = array();
        $amount = 0;
        Config::$serverKey = 'SB-Mid-server-eiuCtSPcL-uxgdvQkBSYaw66';
        if (!isset(Config::$serverKey)) {
            return "Please set your payment server key";
        }
        Config::$isSanitized = true;

        // Enable 3D-Secure
        Config::$is3ds = true;
        
        // Required

         $item_list[] = [
                'id' => "111",
                'price' => 20000,
                'quantity' => 1,
                'name' => "Majohn"
        ];

        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => 20000, // no decimal allowed for creditcard
        );

        // Optional
        $item_details = $item_list;

        // Optional
        $customer_details = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'email'         => "andri@litani.com",
            'phone'         => "081122334455",
        );

        // Optional, remove this to display all available payment methods
        $enable_payments = array();

        // Fill transaction details
        $transaction = array(
            'enabled_payments' => $enable_payments,
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );
        // return $transaction;
        try {
            // dd('Return');
            $snapToken = Snap::getSnapToken($transaction);
            // return response()->json($snapToken);
            return ['code' => 1 , 
                    'message' => 'success' , 
                    'token' => $snapToken,
                    'redirect_url' => 'https://app.sandbox.veritrans.co.id/snap/v2/vtweb/'.$snapToken
                ];
        } catch (\Exception $e) {
            dd($e);
            return ['code' => 0 , 'message' => 'failed'];
        }

    }

}
