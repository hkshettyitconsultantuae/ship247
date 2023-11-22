<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ContainerSizes;
use App\Models\LandSchedule;
use App\Models\Location;
use App\Models\TruckType;
use Illuminate\Http\Request;

class LandSchedulesController extends Controller
{
    const PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search_criteria = [
            'origin_id' => $request->origin_id,
            'destination_id' => $request->destination_id,
            'company_id' => $request->company_id,
            'truck_type_id' => $request->truck_type_id,
            'axle' => $request->axle !== "" ? intval($request->axle) : "",
        ];

        $origin = null;
        $destination = null;
        $company = null;
        $truck_type = null;
        $axle = null;

        $landSchedulesQuery = LandSchedule::query();

        if ($request->origin_id) {
            $origin = Location::find($request->origin_id);
            $landSchedulesQuery->where('origin_id', $request->origin_id);
        }

        if ($request->destination_id) {
            $destination = Location::find($request->destination_id);
            $landSchedulesQuery->where('destination_id', $request->destination_id);
        }

        if ($request->company_id) {
            $company = Company::find($request->company_id);
            $landSchedulesQuery->where('company_id', $request->company_id);
        }

        if ($request->truck_type_id) {
            $truck_type = TruckType::find($request->truck_type_id);
            $landSchedulesQuery->where('truck_type_id', $request->truck_type_id);
        }

        if (isset($request->axle) && $request->axle !== "") {
            $axle = $search_criteria['axle'];
            $landSchedulesQuery->where('axle', $axle);
        }

        $companies = Company::whereNotIn('id', config('constants.IGNORED_COMPANIES'))
            ->pluck('name', 'id');
        $truck_types = TruckType::pluck('display_label', 'id');
        $axles = [
            '0' => 'None',
            '2' => '2 Axles',
            '3' => '3 Axles',
            '4' => '4 Axles',
        ];

        $landSchedules = $landSchedulesQuery->latest()
            ->paginate(self::PER_PAGE)
            ->appends($search_criteria);

        return view('admin.land_schedules.index',
            compact('landSchedules', 'truck_type', 'company', 'axle',
                'truck_types', 'companies', 'axles', 'origin', 'destination'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::whereNotIn('id', config('constants.IGNORED_COMPANIES'))
            ->pluck('name', 'id'); // TODO: Filter Companies by their type
        $container_sizes = ContainerSizes::pluck('display_label', 'value');
        $truck_types = TruckType::pluck('display_label', 'id');
        return view('admin.land_schedules.create',
            compact('companies', 'container_sizes', 'truck_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $landSchedule = new LandSchedule;
        $landSchedule->truck_type_id = $request->truck_type_id;
        $landSchedule->container_size = $request->container_size ?? "";
        $landSchedule->axle = $request->axle;
        $landSchedule->max_load_in_ton = $request->max_load_in_ton;
        $landSchedule->origin_id = $request->origin_id;
        $landSchedule->destination_id = $request->destination_id;
        $landSchedule->company_id = $request->company_id;
        $landSchedule->land_freight = $request->land_freight;
        $landSchedule->available_trucks = $request->available_trucks;
        $landSchedule->tt = $request->tt;
        $landSchedule->detention_charges_per_hour = $request->detention_charges_per_hour;
        $landSchedule->valid_till = $request->valid_till;

        

        $landSchedule->save();

        return redirect()->route('superadmin.land-schedules.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LandSchedule $landSchedule)
    {
        $companies = Company::whereNotIn('id', config('constants.IGNORED_COMPANIES'))
            ->pluck('name', 'id'); // TODO: Filter Companies by their type
        $container_sizes = ContainerSizes::pluck('display_label', 'value');
        $truck_types = TruckType::pluck('display_label', 'id');
        return view('admin.land_schedules.edit',
            compact('companies', 'container_sizes', 'truck_types', 'landSchedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LandSchedule $landSchedule)
    {
        $landSchedule->truck_type_id = $request->truck_type_id;
        $landSchedule->container_size = $request->container_size ?? "";
        $landSchedule->axle = $request->axle;
        $landSchedule->max_load_in_ton = $request->max_load_in_ton;
        $landSchedule->origin_id = $request->origin_id;
        $landSchedule->destination_id = $request->destination_id;
        $landSchedule->company_id = $request->company_id;
        $landSchedule->land_freight = $request->land_freight;
        $landSchedule->available_trucks = $request->available_trucks;
        $landSchedule->tt = $request->tt;
        $landSchedule->detention_charges_per_hour = $request->detention_charges_per_hour;
        $landSchedule->valid_till = $request->valid_till;
        $landSchedule->save();

        return redirect()->route('superadmin.land-schedules.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LandSchedule $landSchedule)
    {
        $landSchedule->delete();

        return redirect()->route('superadmin.land-schedules.index');
    }
}
