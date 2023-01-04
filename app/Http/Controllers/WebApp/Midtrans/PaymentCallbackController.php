<?php

namespace App\Http\Controllers\WebApp\Midtrans;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Midtrans\CallbackService;
use App\Traits\WablasTrait;

class PaymentCallbackController extends Controller
{
    public function receive()
    {
        $callback = new CallbackService;

        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $order = $callback->getOrder();

            if ($callback->isSuccess()) {
                Order::where('id', $order->id)->update([
                    'payment_status' => 'Success',
                ]);

                WablasTrait::payment_confirmation($order);
                WablasTrait::scheduleText($order);
            }

            if ($callback->isExpire()) {
                Order::where('id', $order->id)->update([
                    'payment_status' => 'Expired',
                ]);
            }

            if ($callback->isCancelled()) {
                Order::where('id', $order->id)->update([
                    'payment_status' => 'Canceled   ',
                ]);
            }

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil diproses',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }
    }
}
