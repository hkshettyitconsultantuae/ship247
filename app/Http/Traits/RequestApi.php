<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;

Trait RequestApi
{
    const RESPONSE_TYPE_JSON = 1;
    const RESPONSE_TYPE_PHP = 2;

    public static function convertResponseToProperJSON($response)
    {
        return json_decode('['.rtrim(str_replace("}\n", '},',stripslashes($response)),',').']');
    }

    public static function sendRequest($url, $response_type=self::RESPONSE_TYPE_JSON, $return_raw=false)
    {
        try {
            $response = self::processRequest($url);

            if($response->successful()) {
                $return_data = [
                    'success' => true,
                    'data' => $return_raw ? $response->body() : self::convertResponseToProperJSON($response->body()),
                ];
            } else {
                $return_data = [
                    'success' => false,
                    'error_message' => $response->body(),
                    'data' => "[]",
                    'url' => $url
                ];
            }
        } catch (\Exception $exception) {
            $return_data = [
                'success' => false,
                'error_message' => $exception->getMessage(),
                'error_code' => $exception->getCode()
            ];
        }

        if($response_type === self::RESPONSE_TYPE_JSON){
            return response()->json($return_data);
        } else {
            return $return_data;
        }
    }
}
