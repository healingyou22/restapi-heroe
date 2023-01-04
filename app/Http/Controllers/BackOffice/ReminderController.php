<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\WablasTrait;
use Symfony\Component\HttpFoundation\Response;

class ReminderController extends Controller
{
    public function reminder(Request $request)
    {
        $order = Order::show($request->id);

        WablasTrait::reminder($order);

        $response = [
            'message' => 'Berhasil mengirim Pesan'
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
