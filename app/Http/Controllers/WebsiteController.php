<?php

namespace App\Http\Controllers;

use App\Http\Resources\HotDealResource;
use App\Http\Resources\LocationResource;
use App\Models\Booking;
use App\Models\Industry;
use App\Models\BookingAddon;
use App\Models\HotDeal;
use App\Models\LandSchedule;
use App\Models\News;
use App\Models\ContainerSizes;
use App\Models\Location;
use App\Models\PickAndDeliverySchedule;
use App\Models\SeaSchedule;
use App\Models\TruckType;
use App\Models\User;
use App\Services\CMAAPI;
use App\Services\HapagAPI;
use App\Services\MaerskAPI;
use App\Services\MSCAPI;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\JsonResponse;

class WebsiteController extends Controller
{
    public function home()
    {
        $hot_deals = HotDeal::valid()->latest()->limit(6)->get();
        $hot_deals_collection = HotDealResource::collection($hot_deals);

        $news_listing = News::published()
            ->orderBy('published_date', 'DESC')
            ->take(6)
            ->get();

        return Inertia::render("Home", compact('hot_deals_collection', 'news_listing'));
    }

    public function benefits()
    {
        $news_listing = News::published()
            ->orderBy('published_date', 'DESC')
            ->take(6)
            ->get();

        return Inertia::render("Benefits", compact('news_listing'));
    }

    public function clearance()
    {
        return Inertia::render("Clearance");
    }

    public function services()
    {
        $hot_deals = HotDeal::valid()->latest()->limit(6)->get();
        $hot_deals_collection = HotDealResource::collection($hot_deals);
        return Inertia::render("Services", compact('hot_deals_collection'));
    }

    public function resources()
    {
        return Inertia::render("Resources");
    }

    public function workWithUs()
    {
        return Inertia::render("WorkWithUs");
    }

    public function workWithUsForm(Request $request)
    {
        $industryOptions = Industry::select('name as label', 'id as value')->get();
        return Inertia::render("WorkWithUsForm", compact('industryOptions'));
    }

    public function contact()
    {
        return Inertia::render("Contact");
    }

    public function policy()
    {
        return Inertia::render("Policy");
    }

    public function terms()
    {
        return Inertia::render("Terms");
    }

    public function hotDeals()
    {
        $hot_deals = HotDeal::valid()->latest()->get();
        $hot_deals_collection = HotDealResource::collection($hot_deals);
        return Inertia::render("HotDeals", compact('hot_deals_collection'));
    }

    public function searchresults(Request $request)
    {
        if (isset($request->origin, $request->destination, $request->departure_date)
            && (isset($request->container_size) || isset($request->truck_type))) {
            $searched_origin = Location::where('code', $request->origin)->with('country')->first();
            $searched_destination = Location::where('code', $request->destination)->with('country')->first();
            $searched_container_size = ContainerSizes::where('value', $request->container_size)
                ->select('id', 'display_label', 'value')->first();
            $searched_truck_type = TruckType::find($request->truck_type);
            $searched_departure_date = $request->departure_date;
            $searched_route_type = $request->route_type ?? ROUTE_TYPE_SEA;
            $container_sizes = ContainerSizes::get();
            $truck_types = TruckType::select('display_label', 'id')->get()->toArray();

            $hot_deals = HotDeal::valid()->latest()->limit(4)->get();
            $hot_deals_collection = HotDealResource::collection($hot_deals);
            $user_details = Auth::user() != null ? User::with('company')->find(Auth::user()->id) : null;

            return Inertia::render("SearchResults",
                compact('searched_origin',
                    'searched_destination',
                    'searched_departure_date',
                    'searched_container_size',
                    'searched_truck_type',
                    'searched_route_type',
                    'hot_deals_collection',
                    'container_sizes',
                    'truck_types',
                    'user_details'
                ));
        }
        return redirect()->route('pages.home');
    }

    public function additionalServices() // Booking Step 1
    {
        if (session()->get('booking_details')) {
            $booking_addons = BookingAddon::where('status', 1)->
            select('id', 'name', 'additional_text', 'type', 'default_value', 'step')
                ->get();
            return Inertia::render("AdditionalServices", compact('booking_addons'));
        }

        return redirect()->route('pages.home');
    }

    public function shipmentDetails() // Booking Step 2
    {
        if (session()->get('booking_details')) {
            $shipmentDetails = [
                "addon_details" => session()->get('addon_details'),
                "booking_details" => session()->get('booking_details')
            ];
            return Inertia::render("ShipmentDetails", compact('shipmentDetails'));
        }
        return redirect()->route('pages.home');
    }

    public function bookingCreated(Booking $booking) // Booking Step 3
    {

        if ($booking->user_id === Auth::user()->id) {
            $stripe_key = config('services.stripe.key');
            $booking = Booking::where('id', $booking->id)->with('payment')->first();

            return Inertia::render("BookingCreated", compact('booking', 'stripe_key'));
        }
        return redirect()->route('pages.home');
    }

    public function newsListing(Request $request)
    {
        $latest_news = News::published()
            ->orderBy('published_date', 'DESC')
            ->first();

        $limit = 6;
        $page = $request->has('page') ? $request->get('page') : 1;
        $offset = (($page - 1) * $limit) + 1;
        $news_listing = News::published()
            ->orderBy('published_date', 'DESC')
            ->skip($offset)
            ->take(6)
            ->get();

        $total_news = News::published()->count();
        return Inertia::render("NewsListing",
            compact('news_listing', 'latest_news', 'total_news', 'page', 'limit'));
    }

    public function newsDetails(News $news)
    {
        $news_prev = News::find($news->id - 1);
        $news_next = News::find($news->id + 1);

        return Inertia::render('NewsDetails', compact('news', 'news_prev', 'news_next'));
    }

    public function thankYouPage(Request $request)
    {

        $booking = Booking::with('payment')->find($request->bookingID);
        if ($booking->user_id === Auth::user()->id) {
            // $stripe_key = config('services.stripe.key');
            return Inertia::render("ThankYouPage", compact('booking'));
        }
        return redirect()->route('pages.home');
    }

    public function getLocationsByCity(Request $request): JsonResponse
    {
        $search_term = '%' . $request->city . '%';
        $locations = Location::where(function ($query) use ($search_term) {
            $query->orWhere('port', 'Like', $search_term)
                ->orWhere('code', 'Like', $search_term)
                ->orWhere('city', 'Like', $search_term);
        })->orWhereHas('country', function ($query) use ($search_term) {
            $query->where('name', 'Like', $search_term)
                ->orWhere('code', $search_term);
        })->limit(10)->orderBy('port')->get();

        return response()->json([
            'success' => true,
            'data' => LocationResource::collection($locations)
        ]);
    }

    public function getPointToPointSchedules(Request $request): \Illuminate\Http\JsonResponse
    {
        $return_data = [
            'data' => []
        ];

        $from = Carbon::parse($request->departure_date);
        $to = $from->copy()->addWeeks(4);
        $today = Carbon::today();

        $origin = Location::where('code', $request->origin_code)->first();
        $destination = Location::where('code', $request->destination_code)->first();
        $container_size = ContainerSizes::where('value', $request->container_size)->first();

        if ((int)$request->route_type === ROUTE_TYPE_SEA) {

            if ($request->api === 'maersk') {
                $maersk_response = MaerskAPI::getPointToPointSchedules($request->origin_code, $request->origin_name, $request->origin_geolocation_id,
                    $request->destination_code, $request->destination_name, $request->destination_geolocation_id,
                    $request->container_size, $request->departure_date);

                if (isset($maersk_response['success']) && $maersk_response['success']) {
                    $return_data['data'] = array_merge($return_data['data'], $maersk_response['data']);
                }
            } else if ($request->api === 'cma') {
                $cma_response = CMAAPI::getPointToPointSchedules($request->origin_code, $request->origin_name,
                    $request->destination_code, $request->destination_name, $request->departure_date);

                if (isset($cma_response['success']) && $cma_response['success']) {
                    $return_data['data'] = array_merge($return_data['data'], $cma_response['data']);
                }
            } else if ($request->api === 'hapag') {
                $hapag_response = HapagAPI::getPointToPointSchedulesWithPricing($origin, $destination, $container_size->hapag_value, $request->departure_date);
                if (isset($hapag_response['success']) && $hapag_response['success']) {
                    $return_data['data'] = array_merge($return_data['data'], $hapag_response['data']);
                }
            } else if ($request->api === 'msc') {
                $msc_response = MSCAPI::getPointToPointSchedulesWithPricing($origin, $destination, $container_size->msc_value, $request->departure_date);
                if (isset($msc_response['success']) && $msc_response['success']) {
                    $return_data['data'] = array_merge($return_data['data'], $msc_response['data']);
                }
            } else if ($request->api === 'custom') {
                // Only from Sea Schedules
                $custom_schedules = SeaSchedule::where('origin_id', $request->origin_id)
                    ->where('destination_id', $request->destination_id)
                    ->where('container_size', $request->container_size)
                    ->whereHas('details', function ($query) use ($today) {
                        $query->whereDate('valid_till', '>=', $today);
                    })->with('details')
                    ->get();

                // Starts from PICKUP AND DELIVERY
                // Ends On PICKUP AND DELIVERY
                $custom_schedules2 = SeaSchedule::where('container_size', $request->container_size)
                    ->whereHas('details', function ($query) use ($today) {
                        $query->whereDate('valid_till', '>=', $today);
                    })->with('details')
                    ->whereHas('pickupAndDeliveryScheduleOrigin', function ($q) use ($request, $today) {
                        $q->filterByOriginAndContainerSize($request->origin_id, $request->container_size, $today);
                    })
                    ->whereHas('pickupAndDeliveryScheduleDestination', function ($q) use ($request, $today) {
                        $q->filterByDestinationAndContainerSize($request->destination_id, $request->container_size, $today);
                    })->get();

                // Starts from PICKUP AND DELIVERY
                // Ends On Sea Schedules
                $custom_schedules3 = SeaSchedule::where('destination_id', $request->destination_id)
                    ->where('container_size', $request->container_size)
                    ->whereHas('details', function ($query) use ($today) {
                        $query->whereDate('valid_till', '>=', $today);
                    })->with('details')
                    ->whereHas('pickupAndDeliveryScheduleOrigin', function ($q) use ($request, $today) {
                        $q->filterByOriginAndContainerSize($request->origin_id, $request->container_size, $today);
                    })->get();

                // Starts from Sea Schedules
                // Ends On PICKUP AND DELIVERY
                $custom_schedules4 = SeaSchedule::where('origin_id', $request->origin_id)
                    ->where('container_size', $request->container_size)
                    ->whereHas('details', function ($query) use ($today) {
                        $query->whereDate('valid_till', '>=', $today);
                    })->with('details')
                    ->whereHas('pickupAndDeliveryScheduleDestination', function ($q) use ($request, $today) {
                        $q->filterByDestinationAndContainerSize($request->destination_id, $request->container_size, $today);
                    })->get();

                $pickup_locations = PickAndDeliverySchedule::filterByOriginAndContainerSize($request->origin_id, $request->container_size, $today)->get();
                $delivery_locations = PickAndDeliverySchedule::filterByDestinationAndContainerSize($request->destination_id, $request->container_size, $today)->get();

                $custom_schedules = $custom_schedules->merge($custom_schedules2)
                    ->merge($custom_schedules3)
                    ->merge($custom_schedules4);
            }
        } else if ((int)$request->route_type === ROUTE_TYPE_LAND) {
            $custom_schedules = LandSchedule::where('origin_id', $request->origin_id)
                ->where('destination_id', $request->destination_id)
                ->whereDate('valid_till', '>=', $today)
                ->where('truck_type_id', $request->truck_type)
                ->get();
        }

        if (isset($custom_schedules)) {
            $custom_schedules_data = [];
            foreach ($custom_schedules as $custom_schedule) {
                if ($request->api === 'custom' && (int)$request->route_type === ROUTE_TYPE_SEA) {
                    foreach ($custom_schedule->details as $details) {
                        if ($details->etd->between($from, $to)) {
                            $price_details = [
                                'pickup_charges' => $custom_schedule->pickup_charges,
                                'origin_charges' => $custom_schedule->origin_charges,
                                'origin_charges_included' => $custom_schedule->origin_charges_included,
                                'freight_charges' => $custom_schedule->ocean_freight,
                                'destination_charges' => $custom_schedule->destination_charges,
                                'destination_charges_included' => $custom_schedule->destination_charges_included,
                                'delivery_charges' => $custom_schedule->delivery_charges,
                            ];
                            $custom_schedule_data = [
                                'schedule_id' => $custom_schedule->id,
                                'company_id' => $custom_schedule->company->id,
                                'company_name' => $custom_schedule->company->name,
                                'pickup_name' => $custom_schedule->origin->shortname,
                                'origin_code' => $custom_schedule->origin->code,
                                'destination_code' => $custom_schedule->destination->code,
                                'delivery_name' => $custom_schedule->destination->shortname,
                                'etd' => $details->etd->toDateString(),
                                'eta' => $details->eta->toDateString(),
                                'valid_till' => $details->valid_till->toDateString(),
                                'tt' => $details->tt,
                                'ft' => $details->ft,
                                'price_amount' => $custom_schedule->ocean_freight,
                            ];

                            if ($custom_schedule->origin_id != $request->origin_id && $custom_schedule->destination_id != $request->destination_id) {
                                foreach ($pickup_locations as $pickup) {
                                    foreach ($delivery_locations as $delivery) {
                                        $custom_schedules_data[] = array_merge(
                                            $custom_schedule_data,
                                            [
                                                'delivery_id' => $delivery->id,
                                                'pickup_id' => $pickup->id,
                                                'pickup_name' => $pickup->origin->shortname,
                                                'delivery_name' => $delivery->destination->shortname,
                                                'price_details' => array_merge($price_details, [
                                                    'pickup_charges' => $pickup->price,
                                                    'delivery_charges' => $delivery->price
                                                ])
                                            ]
                                        );
                                    }
                                }
                            } else if ($custom_schedule->origin_id != $request->origin_id) {
                                foreach ($pickup_locations as $pickup) {
                                    $custom_schedules_data[] = array_merge(
                                        $custom_schedule_data,
                                        [
                                            'pickup_id' => $pickup->id,
                                            'pickup_name' => $pickup->origin->shortname,
                                            'price_details' => array_merge($price_details, ['pickup_charges' => $pickup->price])
                                        ]
                                    );
                                }
                            } else if ($custom_schedule->destination_id != $request->destination_id) {
                                foreach ($delivery_locations as $delivery) {
                                    $custom_schedules_data[] = array_merge(
                                        $custom_schedule_data,
                                        [
                                            'delivery_id' => $delivery->id,
                                            'delivery_name' => $delivery->destination->shortname,
                                            'price_details' => array_merge($price_details, ['delivery_charges' => $delivery->price])
                                        ]
                                    );
                                }
                            } else {
                                $custom_schedules_data[] = array_merge(
                                    $custom_schedule_data,
                                    [
                                        'price_details' => $price_details
                                    ]
                                );
                            }
                        }
                    }
                } else if ((int)$request->route_type === ROUTE_TYPE_LAND) {
                    $custom_schedules_data[] = [
                        'company_id' => $custom_schedule->company->id,
                        'company_name' => $custom_schedule->company->name,
                        'origin_code' => $custom_schedule->origin->code,
                        'origin_name' => $custom_schedule->origin->port,
                        'destination_code' => $custom_schedule->destination->code,
                        'destination_name' => $custom_schedule->destination->port,
                        'truck_type' => [
                            'id' => $custom_schedule->truckType->id,
                            'display_label' => $custom_schedule->truckType->display_label,
                        ],
                        'axle' => $custom_schedule->axle,
                        'max_load_in_ton' => $custom_schedule->max_load_in_ton,
                        'available_trucks' => $custom_schedule->available_trucks,
                        'detention_charges_per_hour' => $custom_schedule->detention_charges_per_hour,
                        'valid_till' => $custom_schedule->valid_till->toDateString(),
                        'tt' => $custom_schedule->tt,
                        'price_amount' => $custom_schedule->land_freight,
                        'price_details' => [
                            'freight_charges' => $custom_schedule->land_freight,
                        ]
                    ];
                }
            }

            $return_data['data'] = array_merge($return_data['data'], $custom_schedules_data);
        }

        return response()->json([
            'success' => !empty($return_data['data']),
            'data' => $return_data['data'],
        ]);
    }

    public function getPointToPointPrices(Request $request): \Illuminate\Http\JsonResponse
    {
        $return_data = [
            'data' => []
        ];

        $origin = json_decode($request->origin);
        $destination = json_decode($request->destination);
        $container_size = json_decode($request->container_size);
        $container_size_obj = ContainerSizes::where('value', $container_size->value)->first();

        if ($request->api === 'maersk' && isset($origin->city, $origin->country, $destination->city, $destination->country, $container_size->label)) {
            $maersk_response = MaerskAPI::scrapePriceByOriginDestination(
                $origin->city ? $origin->city . ', ' . $origin->country : $origin->port . ', ' . $origin->country,
                $destination->city ? $destination->city . ', ' . $destination->country : $destination->port . ', ' . $destination->country,
                $container_size->label,
                $request->departure_date
            );

            if (!empty($maersk_response['success']) && !empty($maersk_response['data'][0]->data->schedules)) {
                $return_data['data'] = $maersk_response['data'][0]->data->schedules;
            }
        } else if ($request->api === 'cma' && isset($origin->code, $destination->code, $request->cma_departure_dates, $container_size_obj) && $request->cma_departure_dates) {
            $cma_response = CMAAPI::getPrices($origin->code, $destination->code, json_decode($request->cma_departure_dates),
                $container_size_obj->cma_value);

            if (!empty($cma_response['success'])) {
                $return_data['data'] = $cma_response['data'];
            }
        }

        return response()->json([
            'success' => !empty($return_data['data']),
            'data' => $return_data['data'],
        ]);
    }
}
