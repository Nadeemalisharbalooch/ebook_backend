<?php

namespace App\Services;

class ResponseService
{
    public static function success($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error($data = null, $message = 'Error', $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function notFound($message = 'Not Found', $code = 404)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }
}
