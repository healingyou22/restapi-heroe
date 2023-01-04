<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Report;
use App\Models\User;
use App\Services\Midtrans\CreateSnapTokenService;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index()
    {
        if (auth('api')->check()) {
            $userRole = auth('api')->user()->role;

            if ($userRole == 'klien') {

                $response = [
                    'message' => 'user has no authority'
                ];

                return response()->json($response, Response::HTTP_FORBIDDEN);
            }


            $response = [
                'message' => 'success',
                'data' => Order::index()
            ];

            return response()->json($response, Response::HTTP_OK);
        }

        $response = [
            'message' => 'user not logged in'
        ];

        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }

    public function store(Request $request)
    {
        if (auth('api')->check()) {

            $validator = Validator::make($request->all(), [
                'pricing_id' => 'required',
                'full_name' => 'required',
                'address' => 'required',
                'whatsapp_num' => 'required',
                'date' => 'required|after:tomorrow',
                'location' => 'required',
                'total_price' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            try {
                $checkdate = Order::select('date')->where('date', $request->date)->count();

                if ($checkdate >= 3) {
                    return response()->json('Failed~', Response::HTTP_BAD_REQUEST);
                }

                $userId = auth('api')->user()->id;

                $unicode = mt_rand(1000000000, 9999999999);

                $midtrans = new CreateSnapTokenService($request->all(), $unicode);
                $snapToken = $midtrans->getSnapToken();

                Order::store($request->all(), $snapToken, $unicode, $userId);

                $response = [
                    'message' => 'success',
                ];

                return response()->json($response, Response::HTTP_CREATED);
            } catch (QueryException $e) {
                return response()->json([
                    'message' => "Failed" . $e->errorInfo
                ]);
            }
        }
        $response = [
            'message' => 'user not logged in'
        ];

        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }

    public function show($id)
    {
        if (auth('api')->check()) {

            $response = [
                'message' => 'success',
                'data' => Order::show($id)
            ];

            return response()->json($response, Response::HTTP_OK);
        }

        $response = [
            'message' => 'user not logged in'
        ];

        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }

    public function cancel($id)
    {
        if (auth('api')->check()) {
            $userRole = auth('api')->user()->role;

            if ($userRole == 'klien') {

                $response = [
                    'message' => 'user has no authority'
                ];

                return response()->json($response, Response::HTTP_FORBIDDEN);
            }

            $status = Order::findOrFail($id);

            if ($status['order_status'] !== 'On Going') {
                $response = [
                    'message' => 'order can not be canceled',
                ];

                return response()->json($response, Response::HTTP_EXPECTATION_FAILED);
            }

            Order::cancel($id);
            $data = Order::show($id);

            $response = [
                'message' => 'success',
                'data' => Report::store($data)
            ];

            return response()->json($response, Response::HTTP_OK);
        }

        $response = [
            'message' => 'user not logged in'
        ];

        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }

    public function list()
    {
        if (auth('api')->check()) {
            $userId = auth('api')->user()->id;

            $response = [
                'message' => 'success',
                'data' => Order::list($userId),
            ];

            return response()->json($response, Response::HTTP_OK);
        }

        $response = [
            'message' => 'user not logged in'
        ];

        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }
}
