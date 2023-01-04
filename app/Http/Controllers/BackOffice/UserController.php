<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        if (auth('api')->check()) {
            $userRole = auth('api')->user()->role;

            if ($userRole == 'administrator') {

                $response = [
                    'message' => 'success',
                    'data' => User::index()
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

    public function store(Request $request)
    {
        if (auth('api')->check()) {
            $userRole = auth('api')->user()->role;

            if ($userRole == 'administrator') {
                $validator = Validator::make($request->all(), [
                    'name' => "required|max:255",
                    'email' => "required|max:255|email:dns|unique:users",
                    'whatsapp_num' => 'required', 'numeric',
                    'password'  => 'required|min:8',
                ]);

                if ($validator->fails()) {
                    return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                try {
                    User::store($request->all());

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
                    'data' => User::show($id)
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

    public function update(Request $request, $id)
    {
        if (auth('api')->check()) {
            $userRole = auth('api')->user()->role;

            if ($userRole == 'administrator') {
                $validator = Validator::make($request->all(), [
                    'name' => "required|max:255",
                    'email' => "required|max:255|email:dns|unique:users,email,$id",
                    'whatsapp_num' => 'required', 'numeric',
                ]);

                if ($validator->fails()) {
                    return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                try {
                    User::updateUser($request->all(), $id);

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
                'message' => 'user has no authority'
            ];

            return response()->json($response, Response::HTTP_FORBIDDEN);
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

            if ($userRole == 'administrator') {
                try {
                    User::destroy($id);

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
