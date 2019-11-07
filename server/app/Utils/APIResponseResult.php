<?php

namespace Utils;

use Constants\ApiResponseStatusCode as API_RESPONSE_STATUS_CODE;

class APIResponseResult
{
    public static function OK($data = null)
    {
        return response()->json([ 
            'statusCode' => API_RESPONSE_STATUS_CODE::OK,
            'data' => $data
        ]);
    }

    public static function ERROR($error)
    {
        return response()->json([
            'statusCode' => API_RESPONSE_STATUS_CODE::BAD_REQUEST,
            'errorMessage' => $error
        ]);
    }
}

?>