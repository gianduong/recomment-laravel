<?php
if (!function_exists("successResponse")) {
    function successResponse($data)
    {
        if (is_null($data)) {
            $data = [];
        }
        $response = array_merge([
            'code' => 200,
            'status' => 'success',
        ], ['data' => $data]);
        return response()->json($response, 200);
    }
}

function errorResponse($data)
{
    $response = [
        'code' => 422,
        'status' => 'error',
        'data' => $data,
        'message' => 'Unprocessable Entity'
    ];
    return response()->json($response, $response['code']);
}
