<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class GalleryController extends Controller
{
    public function index()
    {
        $response = [
            'message' => 'success',
            'data' => Gallery::index()
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

            if ($request->hasFile('image')) {
                $imageFullName = $request->file('image')->getClientOriginalName();

                $request->file('image')->storeAs('images', $imageFullName);

                Gallery::store($imageFullName, $request->title, $userId);

                $response = [
                    'message' => 'success',
                ];

                return response()->json($response, Response::HTTP_OK);
            }

            $response = [
                'message' => 'image required'
            ];

            return response()->json($response, Response::HTTP_BAD_REQUEST);
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

                $gallery = Gallery::find($id);

                $explode = explode("http://127.0.0.1:8080/storage/images/", $gallery->image);

                if (Storage::exists('images/' . $explode[1])) {
                    Storage::delete('images/' . $explode[1]);
                    Gallery::destroy($id);

                    $response = [
                        'message' => 'success',
                    ];

                    return response()->json($response, Response::HTTP_OK);
                }
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
