<?php

namespace App\Http\Controllers;

use App\Models\HotDeal;
use App\Models\Company;
use App\Models\Location;
use App\Models\ContainerSizes;
use App\Models\TruckType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HotDealsController extends Controller
{
    const PER_PAGE = 15;

    public function __construct(Request $request)
    {
        $is_route_type_sea = str_contains(\Illuminate\Support\Facades\Route::currentRouteName(), 'sea');

        $request->merge([
            'route_type' => $is_route_type_sea ? ROUTE_TYPE_SEA : ROUTE_TYPE_LAND,
            'route_type_name' => $is_route_type_sea ? "SEA" : 'LAND',
            'route_type_addition' => $is_route_type_sea ? "sea" : 'land',
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $hot_deals_query = HotDeal::where('route_type', $request->route_type);
        // TODO: Add Filters
        $hot_deals = $hot_deals_query->latest()->paginate(self::PER_PAGE);
        return view('admin.hot_deals.index', compact('hot_deals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::whereIn('id', config('constants.IGNORED_COMPANIES'))
            ->pluck('name', 'id'); // TODO: Filter Companies by their type
        // $containerSizes = ContainerSizes::pluck('display_label', 'value');
        $container_sizes = ContainerSizes::pluck('display_label', 'value');
        $truck_types = TruckType::pluck('display_label', 'id');
        return view('admin.hot_deals.create', compact('companies', 'container_sizes', 'truck_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       
        $hot_deal = new HotDeal;
        $hot_deal->origin_id = $request->origin_id;
        $hot_deal->destination_id = $request->destination_id;
        $hot_deal->company_id = $request->company_id;
        $hot_deal->container_size = $request->container_size ?? "";
        $hot_deal->eta = Carbon::parse($request->eta);
        $hot_deal->etd = Carbon::parse($request->etd);
        $hot_deal->tt = $request->tt;
        $hot_deal->start_date = Carbon::parse($request->start_date);
        $hot_deal->end_date = Carbon::parse($request->end_date);
        $hot_deal->valid_till = Carbon::parse($request->valid_till);
        $hot_deal->amount = $request->amount;
        $hot_deal->truck_type_id = $request->truck_type_id;
        $hot_deal->axle = $request->axle;
        $hot_deal->max_load_in_ton = $request->max_load_in_ton;
        $hot_deal->land_freight = $request->land_freight;
        $hot_deal->available_trucks = $request->available_trucks;
        $hot_deal->tt = $request->tt;
        $hot_deal->detention_charges_per_hour = $request->detention_charges_per_hour;
        $hot_deal->valid_till = $request->valid_till;
        $hot_deal->route_type = $request->route_type;
        $hot_deal->save();
        return $this->redirectToIndex($request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, HotDeal $hot_deal)
    {
        // Check that Route is editing in Correct type forms
        $this->verifyHotdealRouteType($request, $hot_deal);
        $container_sizes = ContainerSizes::pluck('display_label', 'value');
        $truck_types = TruckType::pluck('display_label', 'id');
        $companies = Company::whereIn('id', config('constants.IGNORED_COMPANIES'))
            ->pluck('name', 'id'); // TODO: Filter Companies by their type
        $containerSizes = ContainerSizes::pluck('display_label', 'value');
        return view('admin.hot_deals.edit', compact('hot_deal', 'companies', 'container_sizes', 'truck_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HotDeal $hot_deal)
    {
        $hot_deal->origin_id = $request->origin_id;
        $hot_deal->destination_id = $request->destination_id;
        $hot_deal->company_id = $request->company_id;
        $hot_deal->container_size = $request->container_size;
        $hot_deal->eta = Carbon::parse($request->eta);
        $hot_deal->etd = Carbon::parse($request->etd);
        $hot_deal->tt = $request->tt;
        $hot_deal->start_date = Carbon::parse($request->start_date);
        $hot_deal->end_date = Carbon::parse($request->end_date);
        $hot_deal->amount = $request->amount;
        $hot_deal->truck_type_id = $request->truck_type_id;
        $hot_deal->axle = $request->axle;
        $hot_deal->max_load_in_ton = $request->max_load_in_ton;
        $hot_deal->land_freight = $request->land_freight;
        $hot_deal->available_trucks = $request->available_trucks;
        $hot_deal->tt = $request->tt;
        $hot_deal->detention_charges_per_hour = $request->detention_charges_per_hour;
        $hot_deal->valid_till = $request->valid_till;
        $hot_deal->route_type = $request->route_type;
        $hot_deal->save();

        return $this->redirectToIndex($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, HotDeal $hot_deal)
    {
        // Check that Route is editing in Correct type forms
        $this->verifyHotdealRouteType($request, $hot_deal);

        $hot_deal->delete();

        return $this->redirectToIndex($request);
    }

    private function redirectToIndex(Request $request)
    {
        if ($request->route_type === ROUTE_TYPE_SEA) {
            $redirect_to = 'superadmin.sea-hot-deals.index';
        } else {
            $redirect_to = 'superadmin.land-hot-deals.index';
        }

        return redirect()->route($redirect_to);
    }

    private function verifyHotdealRouteType(Request $request, HotDeal $hot_deal)
    {
        if ($hot_deal->route_type != $request->route_type) {
            abort(404);
        }
    }
}
