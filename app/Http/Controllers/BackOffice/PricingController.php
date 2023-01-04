<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PricingController extends Controller
{
    public function index()
    {
        $response = [
            'message' => 'success',
            'data' => Pricing::index()
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        if (auth('api')->check()) {
            $userId = auth('api')->user()->id;
            $userRole = auth('api')->user()->role;

            if ($userRole == 'klien') {

                $response = [
                    'message' => 'user has no authority'
                ];

                return response()->json($response, Response::HTTP_FORBIDDEN);
            }

            $validator = Validator::make($request->all(), [
                'pricing_name' => ['required', 'string', 'max:255'],
                'pricing_type' => ['required'],
                'pricing_desc' => ['required', 'string', 'max:255'],
                'pricing_detail_1' => ['max:255', 'nullable'],
                'pricing_detail_2' => ['max:255', 'nullable'],
                'pricing_detail_3' => ['max:255', 'nullable'],
                'pricing_detail_4' => ['max:255', 'nullable'],
                'pricing_detail_5' => ['max:255', 'nullable'],
                'pricing_detail_6' => ['max:255', 'nullable'],
                'pricing_detail_7' => ['max:255', 'nullable'],
                'pricing_detail_8' => ['max:255', 'nullable'],
                'pricing_detail_9' => ['max:255', 'nullable'],
                'pricing_detail_10' => ['max:255', 'nullable'],
                'pricing_price' => ['required', 'numeric'],
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            try {
                Pricing::store($request->all(), $userId);

                $response = [
                    'message' => 'success',
                ];

                return response()->json($response, Response::HTTP_OK);
            } catch (QueryException $e) {
                return response()->json([
                    'message' => "failed" . $e->errorInfo
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
        $response = [
            'message' => 'success',
            'data' => Pricing::show($id)
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        if (auth('api')->check()) {
            $userId = auth('api')->user()->id;
            $userRole = auth('api')->user()->role;

            if ($userRole == 'klien') {

                $response = [
                    'message' => 'user has no authority'
                ];

                return response()->json($response, Response::HTTP_FORBIDDEN);
            }

            $validator = Validator::make($request->all(), [
                'pricing_name' => ['required', 'string', 'max:255'],
                'pricing_type' => ['required'],
                'pricing_desc' => ['required', 'string', 'max:255'],
                'pricing_detail_1' => ['max:255', 'nullable'],
                'pricing_detail_2' => ['max:255', 'nullable'],
                'pricing_detail_3' => ['max:255', 'nullable'],
                'pricing_detail_4' => ['max:255', 'nullable'],
                'pricing_detail_5' => ['max:255', 'nullable'],
                'pricing_detail_6' => ['max:255', 'nullable'],
                'pricing_detail_7' => ['max:255', 'nullable'],
                'pricing_detail_8' => ['max:255', 'nullable'],
                'pricing_detail_9' => ['max:255', 'nullable'],
                'pricing_detail_10' => ['max:255', 'nullable'],
                'pricing_price' => ['required', 'numeric'],
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            try {
                Pricing::updatePricing($request->all(), $id, $userId);

                $response = [
                    'message' => 'success',
                ];

                return response()->json($response, Response::HTTP_OK);
            } catch (QueryException $e) {
                return response()->json([
                    'message' => "failed" . $e->errorInfo
                ]);
            }
        }

        $response = [
            'message' => 'user not logged in'
        ];

        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }

    public function destroy($id)
    {
        if (auth('api')->check()) {
            $userRole = auth('api')->user()->role;

            if ($userRole == 'klien') {

                $response = [
                    'message' => 'user has no authority'
                ];

                return response()->json($response, Response::HTTP_FORBIDDEN);
            }

            try {
                Pricing::destroy($id);

                $response = [
                    'message' => 'success'
                ];

                return response()->json($response, Response::HTTP_OK);
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
}
