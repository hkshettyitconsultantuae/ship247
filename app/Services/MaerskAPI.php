<?php

namespace App\Services;

use Carbon\Carbon;
use App\Http\Traits\RequestApi;
use Illuminate\Support\Facades\Http;
use App\Http\Interfaces\APIProcessRequest;

class MaerskAPI implements APIProcessRequest
{
    use RequestApi;

    protected const ROOT_URL = 'https://api.maersk.com';

    public static function processRequest($url)
    {
        return Http::withHeaders(['Consumer-Key' => env('MAERSK_API_KEY')])->get($url);
    }

    public static function getLocationsByCity($city)
    {
        $url = self::ROOT_URL."/reference-data/locations?locationType=CITY";
        $url .= "&cityName={$city}&vesselOperatorCarrierCode=MAEU";
        $url .= "&sort=countryName,cityName&limit=25";

        return self::sendRequest($url);
    }

    public static function getPointToPointSchedules($origin_code, $origin_name, $origin_geolocation_id,
                                                    $destination_code, $destination_name, $destination_geolocation_id,
                                                    $container_size, $departure_date)
    {
        $cargo_type = str_contains($container_size, 'R') ? 'REEF' : 'DRY';
        $url = self::ROOT_URL."/products/ocean-products";
        $url .= "?carrierCollectionOriginGeoID={$origin_geolocation_id}&carrierDeliveryDestinationGeoID={$destination_geolocation_id}";
        $url .= "&vesselOperatorCarrierCode=MAEU&cargoType={$cargo_type}&ISOEquipmentCode={$container_size}&stuffingWeight=18000";
        $url .= "&weightMeasurementUnit=KGS&stuffingVolume=10&volumeMeasurementUnit=MTQ&exportServiceMode=CY";
        $url .= "&importServiceMode=CY&startDate={$departure_date}&startDateType=D&dateRange=P4W";
        $url .= "&sort=countryName,cityName&limit=25";

        $response = self::sendRequest($url, self::RESPONSE_TYPE_PHP);

        $return_data = [
            'success' => false,
            'data' => [],
        ];

        if(!isset($response['data'])){
            return $return_data;
        }

        if(isset($response['success']) && $response['success']) {
            $maersk_filtered_data = [];
            foreach($response['data'][0]->oceanProducts[0]->transportSchedules as $data) {
                $departure_date = Carbon::parse($data->departureDateTime);
                $arrival_date = Carbon::parse($data->arrivalDateTime);
                $valid_till = Carbon::parse($data->departureDateTime)->subDays(2);
                $voyage_number = "";
                if(isset($data->transportLegs[0], $data->transportLegs[0]->transport,
                    $data->transportLegs[0]->transport->carrierDepartureVoyageNumber) ) {
                    $voyage_number = $data->transportLegs[0]->transport->carrierDepartureVoyageNumber;
                }
                $maersk_filtered_data[] = [
                    'company_id' => env('MAERSK_COMPANY_ID'),
                    'company' => 'Maersk',
                    'origin_code' => $origin_code,
                    'origin_name' => $origin_name,
                    'destination_code' => $destination_code,
                    'destination_name' => $destination_name,
                    'etd' => $departure_date->format('Y-m-d'),
                    'eta' => $arrival_date->format('Y-m-d'),
                    'valid_till' => $valid_till->format('Y-m-d'),
                    'tt' => round($data->transitTime / 1440),
                    'voyage_number' => $voyage_number,
                ];
            }

            $return_data = [
                'success' => true,
                'data' => $maersk_filtered_data,
            ];
        }

        return $return_data;
    }

    public static function getLocationByUNLocCode($code)
    {
        $url = self::ROOT_URL."/reference-data/locations?locationType=CITY";
        $url .= "&UNLocationCode={$code}&vesselOperatorCarrierCode=MAEU";
        $url .= "&sort=cityName&limit=25";

        return self::sendRequest($url, self::RESPONSE_TYPE_PHP);
    }

    public static function scrapePriceByOriginDestination($origin, $destination, $container_size, $departure_date)
    {
        $url = env('MAERSK_PRICE_SCRAPE_API_ENDPOINT');
        $url .= "?origin={$origin}";
        $url .= "&destination={$destination}";
        $url .= "&container_type={$container_size}";
        $url .= "&date={$departure_date}";

//       return [
//               'success' => true,
//               'data' => json_decode('[{"data":{"container_type":"40 Dry Standard","date":"2023-07-19","destination":"Abu Dhabi, United Arab Emirates","message":"Schedules found","noSchedules":false,"origin":"Port Said East, Egypt","schedules":[{"departure_date":"2023-07-20","destination_charges":[{"amount":"500.0","amountusd":"136.13","comment":"PER_DOC","currency":"AED","name":"Documentation fee - Destination"},{"amount":"185.0","amountusd":"50.37","comment":"PER_CONTAINER","currency":"AED","name":"Container Protect Unlimited"},{"amount":"1065.0","amountusd":"289.96","comment":"PER_CONTAINER","currency":"AED","name":"Terminal Handling Service - Destination"}],"destination_charges_total_usd":476.46,"free_time":3,"freight_charges":[{"amount":"-365.0","amountusd":"-365.0","comment":"PER_CONTAINER","currency":"USD","name":"Basic Ocean Freight"},{"amount":"182.0","amountusd":"182.0","comment":"PER_CONTAINER","currency":"USD","name":"Environmental Fuel Fee"},{"amount":"84.0","amountusd":"84.0","comment":"PER_CONTAINER","currency":"USD","name":"Gulf Emergency Risk Surcharge"}],"freight_charges_total_usd":-99.0,"offer_id":"O_P094wm9w","origin_charges":[{"amount":"185.0","amountusd":"185.0","comment":"PER_CONTAINER","currency":"USD","name":"Free In Service"}],"origin_charges_total_usd":185.0,"total_price":"562","total_price_currency":"USD"},{"departure_date":"2023-07-25","destination_charges":[{"amount":"500.0","amountusd":"136.13","comment":"PER_DOC","currency":"AED","name":"Documentation fee - Destination"},{"amount":"185.0","amountusd":"50.37","comment":"PER_CONTAINER","currency":"AED","name":"Container Protect Unlimited"},{"amount":"1065.0","amountusd":"289.96","comment":"PER_CONTAINER","currency":"AED","name":"Terminal Handling Service - Destination"}],"destination_charges_total_usd":476.46,"free_time":3,"freight_charges":[{"amount":"-311.0","amountusd":"-311.0","comment":"PER_CONTAINER","currency":"USD","name":"Basic Ocean Freight"},{"amount":"182.0","amountusd":"182.0","comment":"PER_CONTAINER","currency":"USD","name":"Environmental Fuel Fee"},{"amount":"84.0","amountusd":"84.0","comment":"PER_CONTAINER","currency":"USD","name":"Gulf Emergency Risk Surcharge"}],"freight_charges_total_usd":-45.0,"offer_id":"O_P094wmcm","origin_charges":[{"amount":"185.0","amountusd":"185.0","comment":"PER_CONTAINER","currency":"USD","name":"Free In Service"}],"origin_charges_total_usd":185.0,"total_price":"616","total_price_currency":"USD"},{"departure_date":"2023-07-29","destination_charges":[{"amount":"500.0","amountusd":"136.13","comment":"PER_DOC","currency":"AED","name":"Documentation fee - Destination"},{"amount":"185.0","amountusd":"50.37","comment":"PER_CONTAINER","currency":"AED","name":"Container Protect Unlimited"},{"amount":"1065.0","amountusd":"289.96","comment":"PER_CONTAINER","currency":"AED","name":"Terminal Handling Service - Destination"}],"destination_charges_total_usd":476.46,"free_time":3,"freight_charges":[{"amount":"-311.0","amountusd":"-311.0","comment":"PER_CONTAINER","currency":"USD","name":"Basic Ocean Freight"},{"amount":"182.0","amountusd":"182.0","comment":"PER_CONTAINER","currency":"USD","name":"Environmental Fuel Fee"},{"amount":"84.0","amountusd":"84.0","comment":"PER_CONTAINER","currency":"USD","name":"Gulf Emergency Risk Surcharge"}],"freight_charges_total_usd":-45.0,"offer_id":"O_P094wmcn","origin_charges":[{"amount":"185.0","amountusd":"185.0","comment":"PER_CONTAINER","currency":"USD","name":"Free In Service"}],"origin_charges_total_usd":185.0,"total_price":"616","total_price_currency":"USD"},{"departure_date":"2023-08-05","destination_charges":[{"amount":"500.0","amountusd":"136.13","comment":"PER_DOC","currency":"AED","name":"Documentation fee - Destination"},{"amount":"185.0","amountusd":"50.37","comment":"PER_CONTAINER","currency":"AED","name":"Container Protect Unlimited"},{"amount":"1065.0","amountusd":"289.96","comment":"PER_CONTAINER","currency":"AED","name":"Terminal Handling Service - Destination"}],"destination_charges_total_usd":476.46,"free_time":3,"freight_charges":[{"amount":"-410.0","amountusd":"-410.0","comment":"PER_CONTAINER","currency":"USD","name":"Basic Ocean Freight"},{"amount":"182.0","amountusd":"182.0","comment":"PER_CONTAINER","currency":"USD","name":"Environmental Fuel Fee"},{"amount":"84.0","amountusd":"84.0","comment":"PER_CONTAINER","currency":"USD","name":"Gulf Emergency Risk Surcharge"}],"freight_charges_total_usd":-144.0,"offer_id":"O_P094wm9y","origin_charges":[{"amount":"185.0","amountusd":"185.0","comment":"PER_CONTAINER","currency":"USD","name":"Free In Service"}],"origin_charges_total_usd":185.0,"total_price":"517","total_price_currency":"USD"},{"departure_date":"2023-08-12","destination_charges":[{"amount":"500.0","amountusd":"136.13","comment":"PER_DOC","currency":"AED","name":"Documentation fee - Destination"},{"amount":"185.0","amountusd":"50.37","comment":"PER_CONTAINER","currency":"AED","name":"Container Protect Unlimited"},{"amount":"1065.0","amountusd":"289.96","comment":"PER_CONTAINER","currency":"AED","name":"Terminal Handling Service - Destination"}],"destination_charges_total_usd":476.46,"free_time":3,"freight_charges":[{"amount":"-416.0","amountusd":"-416.0","comment":"PER_CONTAINER","currency":"USD","name":"Basic Ocean Freight"},{"amount":"182.0","amountusd":"182.0","comment":"PER_CONTAINER","currency":"USD","name":"Environmental Fuel Fee"},{"amount":"84.0","amountusd":"84.0","comment":"PER_CONTAINER","currency":"USD","name":"Gulf Emergency Risk Surcharge"}],"freight_charges_total_usd":-150.0,"offer_id":"O_P094wm5j","origin_charges":[{"amount":"185.0","amountusd":"185.0","comment":"PER_CONTAINER","currency":"USD","name":"Free In Service"}],"origin_charges_total_usd":185.0,"total_price":"511","total_price_currency":"USD"},{"departure_date":"2023-08-19","destination_charges":[{"amount":"500.0","amountusd":"136.13","comment":"PER_DOC","currency":"AED","name":"Documentation fee - Destination"},{"amount":"185.0","amountusd":"50.37","comment":"PER_CONTAINER","currency":"AED","name":"Container Protect Unlimited"},{"amount":"1065.0","amountusd":"289.96","comment":"PER_CONTAINER","currency":"AED","name":"Terminal Handling Service - Destination"}],"destination_charges_total_usd":476.46,"free_time":3,"freight_charges":[{"amount":"-416.0","amountusd":"-416.0","comment":"PER_CONTAINER","currency":"USD","name":"Basic Ocean Freight"},{"amount":"182.0","amountusd":"182.0","comment":"PER_CONTAINER","currency":"USD","name":"Environmental Fuel Fee"},{"amount":"84.0","amountusd":"84.0","comment":"PER_CONTAINER","currency":"USD","name":"Gulf Emergency Risk Surcharge"}],"freight_charges_total_usd":-150.0,"offer_id":"O_P094wm1d","origin_charges":[{"amount":"185.0","amountusd":"185.0","comment":"PER_CONTAINER","currency":"USD","name":"Free In Service"}],"origin_charges_total_usd":185.0,"total_price":"511","total_price_currency":"USD"}]},"status":"success"}]'),
//           ];
        return self::sendRequest($url, self::RESPONSE_TYPE_PHP);
    }
}
