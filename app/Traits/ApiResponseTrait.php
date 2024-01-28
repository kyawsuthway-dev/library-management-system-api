<?php

namespace App\Traits;

use Carbon\Carbon;

trait ApiResponseTrait {
    public function apiResponseSuccess($message = "success!", $data = null, $code = 200)
    {
        $response = [
            'code' => $code,
            'success' => true,
            'message' => $message,
            'time' => Carbon::now(),
            'data' => $data
        ];

        return response()->json($response, $code);
    }

    public function apiResponseError($message = "error!", $code = 403)
    {
        $response = [
            'code' => $code,
            'success' => false,
            'message' => $message,
            'time' => Carbon::now()
        ];

        return response()->json($response, $code);
    }
}