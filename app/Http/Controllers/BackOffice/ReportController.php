<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function index()
    {
        if (auth('api')->check()) {
            $userRole = auth('api')->user()->role;

            if ($userRole == 'administrator') {

                $response = [
                    'message' => 'success',
                    'data' => Report::index()
                ];

                return response()->json($response, Response::HTTP_OK);
            }

            $response = [
                'message' => 'user has no authority'
            ];

            return response()->json($response, Response::HTTP_FORBIDDEN);
        }

        $response = [
            'message' => 'user not logged in'
        ];

        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }

    public function show($id)
    {
        if (auth('api')->check()) {
            $userRole = auth('api')->user()->role;

            if ($userRole == 'administrator') {

                $response = [
                    'message' => 'success',
                    'data' => Report::show($id)
                ];

                return response()->json($response, Response::HTTP_OK);
            }

            $response = [
                'message' => 'user has no authority'
            ];

            return response()->json($response, Response::HTTP_FORBIDDEN);
        }

        $response = [
            'message' => 'user not logged in'
        ];

        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }
}
