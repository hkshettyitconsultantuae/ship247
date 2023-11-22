<?php

namespace App\Services;

use App\Http\Interfaces\APIProcessRequest;
use App\Http\Traits\RequestApi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class CMAAPI implements APIProcessRequest
{
    use RequestApi;

    protected const ROOT_URL = 'https://apis.cma-cgm.net';

    public static function processRequest($url)
    {
        return Http::withHeaders(['KeyId' => env('CMA_API_KEY')])->get($url);
    }

    public static function getPointToPointSchedules($origin_code, $origin_name, $destination_code, $destination_name, $departure_date)
    {
        $url = self::ROOT_URL . "/vesseloperation/route/v2/routings";
        $url .= "?placeOfLoading={$origin_code}&placeOfDischarge={$destination_code}";
        $url .= "&departureDate={$departure_date}&searchRange=14&maxTs=3&useRoutingStatistics=true";

        $response = self::sendRequest($url, self::RESPONSE_TYPE_PHP);

        $return_data = [
            'success' => false,
            'data' => [],
        ];

        if(!isset($response['data'])){
            return $return_data;
        }

        if (isset($response['success']) && $response['success']) {
            $cma_filtered_data = [];

            foreach ($response['data'][0] as $data) {
                if (isset($data->routingDetails[0]->pointFrom->departureDateGmt)) {
                    $departure_date = Carbon::parse($data->routingDetails[0]->pointFrom->departureDateGmt);
                } else {
                    $departure_date = Carbon::parse($data->routingDetails[1]->pointFrom->departureDateGmt);
                }
                if (isset($data->routingDetails[count($data->routingDetails) - 1]->pointTo->arrivalDateGmt)) {
                    $arrival_date = Carbon::parse($data->routingDetails[count($data->routingDetails) - 1]->pointTo->arrivalDateGmt);
                } else {
                    $arrival_date = Carbon::parse($data->routingDetails[count($data->routingDetails) - 2]->pointTo->arrivalDateGmt);
                }
                if (isset($data->routingDetails[0]->pointFrom->cutOff->standardBookingAcceptance->utc)) {
                    $valid_till = Carbon::parse($data->routingDetails[0]->pointFrom->cutOff->standardBookingAcceptance->utc);
                } else {
                    $valid_till = Carbon::parse($data->routingDetails[1]->pointFrom->cutOff->standardBookingAcceptance->utc);
                }

                $cma_filtered_data[] = [
                    'company_id' => env('CMA_COMPANY_ID'),
                    'company' => 'CMA CGM',
                    'origin_code' => $origin_code,
                    'origin_name' => $origin_name,
                    'destination_code' => $destination_code,
                    'destination_name' => $destination_name,
                    'etd' => $departure_date->format('Y-m-d'),
                    'eta' => $arrival_date->format('Y-m-d'),
                    'valid_till' => $valid_till->format('Y-m-d'),
                    'tt' => $data->transitTime
                ];
            }

            $return_data = [
                'success' => true,
                'data' => $cma_filtered_data,
            ];
        }

        return $return_data;
    }

    public static function getPrices($origin_code, $destination_code, $departure_dates, $container_size_cma_value)
    {
        $cma_price_data = [];
        $cargo_type = substr($container_size_cma_value, 2, 2);
        $equipmentSizeType = $container_size_cma_value;

        foreach ($departure_dates as $departure_date) {
            $cma_response = self::getPrice($origin_code, $destination_code, $departure_date, $cargo_type);

            if (!empty($cma_response['success']) && !empty($cma_response['data'][0])) {
                $cma_filtered_data = [];
                foreach ($cma_response['data'][0] as $data) {
                    $total = 0;
                    $surchargesPerEquipment = [];

                    foreach ($data->surcharges->matchingSurchargesPerEquipment as $surcharge) {
                        if ($equipmentSizeType === $surcharge->equipmentSizeType) {
                            foreach ($surcharge->matchingCargoSurcharges as $charge) {
                                if (!empty($charge->amount) || $charge->includedInBasicFreight) {
                                    $surchargesPerEquipment[] = [
                                        'container_size' => $surcharge->equipmentSizeType,
                                        'charge_code' => $charge->charge->chargeCode,
                                        'charge_name' => $charge->charge->chargeName,
                                        'amount' => $charge->amount,
                                        'currency' => $charge->pivotCurrency->currencyCode,
                                        'included' => $charge->includedInBasicFreight,
                                    ];
                                    if (!empty($charge->amount)) {
                                        $total += $charge->amount;
                                    }
                                }
                            }
                        }
                    }

                    if (empty($surchargesPerEquipment)) {
                        continue;
                    }

                    $blSurcharges = [];
                    foreach ($data->surcharges->matchingBlSurcharges as $surcharge) {
                        if (!empty($surcharge->amount)) {
                            $blSurcharges[] = [
                                'charge_code' => $surcharge->charge->chargeCode,
                                'charge_name' => $surcharge->charge->chargeName,
                                'amount' => $surcharge->amount,
                                'currency' => $surcharge->pivotCurrency->currencyCode,
                            ];

                            $total += $surcharge->amount;
                        }
                    }

                    $cma_filtered_data = [
                        'charges' => $surchargesPerEquipment,
                        'extra' => $blSurcharges,
                        'total' => $total,
                    ];
                }
                $cma_price_data[$departure_date] = $cma_filtered_data;
            }
        }

        return [
            'success' => !empty($cma_price_data),
            'data' => $cma_price_data,
        ];
    }

    public static function getPrice($origin_code, $destination_code, $departure_date, $cargo_type)
    {

        $url = self::ROOT_URL . "/pricing/commercial/quotation/v2/publicQuotelines/search";
        $url .= "?portOfLoading={$origin_code}&portOfDischarge={$destination_code}";
        $url .= "&departureDate={$departure_date}&equipmentType={$cargo_type}";

        return self::sendRequest($url, self::RESPONSE_TYPE_PHP);
    }
}
