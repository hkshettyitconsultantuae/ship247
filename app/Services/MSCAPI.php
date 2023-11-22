<?php

namespace App\Services;

use App\Models\Location;
use Carbon\Carbon;
use App\Http\Traits\RequestApi;
use Illuminate\Support\Facades\Http;
use App\Http\Interfaces\APIProcessRequest;

class MSCAPI implements APIProcessRequest
{
    use RequestApi;

    public static function processRequest($url)
    {
        return Http::get($url);
    }

    public static function getPointToPointSchedulesWithPricing(Location $origin, Location $destination, $container_size, $departure_date)
    {
        $url = env('MSC_API_ENDPOINT') . "?origin={$origin->code}&destination={$destination->code}";
        $url .= "&container_type={$container_size}&weight=18000&weight_unit=Kgs&commodity_type=32";
        $url .= "&temperature=null&temperature_unit=null";

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
            $msc_filtered_data = [];

            foreach ($decoded_data->data as $data) {
                if (isset($data->Vessel) && !empty((array)$data->Vessel)
                    && isset($data->charges) && !empty((array)$data->charges)) {

                    $price_details = [
                        'origin_charges' => 0,
                        'freight_charges' => 0,
                        'destination_charges' => 0,
                    ];
                    foreach ($data->charges as $charge) {
                        if (in_array($charge->ChargeType, ["Freight Charge", "Freight Surcharges"])) {
                            $price_details['freight_charges'] += $charge->Amount;
                        } elseif ($charge->ChargeType === "Export Surcharges" && !$charge->IsIncludedInFreight) {
                            $price_details['origin_charges'] += $charge->Amount;
                        } elseif ($charge->ChargeType === "Import Surcharges" && !$charge->IsIncludedInFreight) {
                            $price_details['destination_charges'] += $charge->Amount;
                        }
                    }

                    $price_amount = array_sum($price_details);

                    foreach ($data->Vessel as $schedule) {
                        $arr_schedule = (array)$schedule;
                        $parsed_etd = Carbon::parse($arr_schedule["etd"]);
                        $request_etd = Carbon::parse($departure_date);
                        if ($parsed_etd->diffInDays($request_etd) >= 2) { // Get records comes under valid date
                            $msc_filtered_data[] = [
                                'company_id' => env('MSC_COMPANY_ID'),
                                'company_name' => "MSC",
                                'pickup_name' => $origin->shortname,
                                'origin_code' => $origin->code,
                                'destination_code' => $destination->code,
                                'delivery_name' => $destination->shortname,
                                'etd' => $arr_schedule["etd"],
                                'eta' => $arr_schedule["eta"],
                                'valid_till' => Carbon::parse($arr_schedule["etd"])->subDays(2)->format('Y-m-d'),
                                'tt' => str_replace(" days", "", $arr_schedule["Est.TT."]),
                                'price_details' => $price_details,
                                'price_amount' => $price_amount,
                            ];
                        }
                    }
                }
            }

            $return_data = [
                'success' => true,
                'data' => $msc_filtered_data,
            ];
        }

        return $return_data;
    }
}
