<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Midtrans\Config as MidtransConfig;
use Midtrans\Notification;
use Midtrans\Snap;

class MidtransService
{
    
    public function __construct()
    {
        MidtransConfig::$serverKey = config('midtrans.serverKey');
        MidtransConfig::$isProduction = config('midtrans.isProduction');
        MidtransConfig::$isSanitized = config('midtrans.isSanitized');
        MidtransConfig::$is3ds = config('midtrans.is3ds');
    }

    public function createSnapToken(array $params): string
    {
        try {
            return Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error('Failed to Create Snap Token:' . $e->getMessage());
            throw $e;
        }
    }

    public function handleNotification(): array
    {
        try {
            $notification = new Notification(); // Automatically loads data from the request
            return [
                'order_id' => $notification->order_id,
                'transaction_status' => $notification->transaction_status,
                'gross_amount' => $notification->gross_amount,
                'custom_field1' => $notification->custom_field1, // User ID
                'custom_field2' => $notification->custom_field2, // mortgage request ID
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans notification error: ' . $e->getMessage());
            throw $e;
        }
    }
}
