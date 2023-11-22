<?php

namespace App\Services;

use App\Models\Location;
use Carbon\Carbon;
use App\Http\Traits\RequestApi;
use Illuminate\Support\Facades\Http;
use App\Http\Interfaces\APIProcessRequest;

class HapagAPI implements APIProcessRequest
{
    use RequestApi;


    public static function processRequest($url)
    {
        return Http::get($url);
    }

    public static function getPointToPointSchedulesWithPricing(Location $origin, Location $destination, $container_size, $departure_date)
    {
        $url = env('HAPAG_API_ENDPOINT') . "?container_type=" . urlencode($container_size) . "&origin_type=terminal";
        $url .= "&destination={$destination->code}&container_quantity=11&cargo_weight=1000";
        $url .= "&destination_type=terminal&origin={$origin->code}";

        $response = self::sendRequest($url, self::RESPONSE_TYPE_PHP, true);

        $return_data = [
            'success' => false,
            'data' => [],
        ];

        if(!isset($response['data'])){
            return $return_data;
        }

        $decoded_data = json_decode($response['data']);
        if (isset($decoded_data->status) && $decoded_data->status === 'success') {
            $hapag_filtered_data = [];

            foreach ($decoded_data->data as $data) {
                if (isset($data->spotOffer) && !empty((array)$data->spotOffer)) {
                    $parsed_etd = Carbon::parse($data->etd);
                    $request_etd = Carbon::parse($departure_date);
                    if ($parsed_etd->diffInDays($request_etd) >= 2) { // Get records comes under valid date
                        $hapag_filtered_data[] = [
                            'company_id' => env('HAPAG_COMPANY_ID'),
                            'company_name' => "Hapag Lloyd",
                            'pickup_name' => $origin->shortname,
                            'origin_code' => $origin->code,
                            'destination_code' => $destination->code,
                            'delivery_name' => $destination->shortname,
                            'etd' => $data->etd,
                            'eta' => $data->eta,
                            'valid_till' => Carbon::parse($data->etd)->subDays(2)->format('Y-m-d'),
                            'tt' => $data->transittime,
                            'price_details' => $data->spotOffer
                        ];
                    }
                }
            }

            $return_data = [
                'success' => true,
                'data' => $hapag_filtered_data,
            ];
        }

        return $return_data;
    }
}
