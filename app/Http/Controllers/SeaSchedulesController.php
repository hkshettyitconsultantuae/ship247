<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ContainerSizes;
use App\Models\Location;
use App\Models\SeaSchedule;
use Illuminate\Http\Request;

class SeaSchedulesController extends Controller
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
            'eta_start_date' => $request->eta_start_date,
            'eta_end_date' => $request->eta_end_date,
            'etd_start_date' => $request->etd_start_date,
            'etd_end_date' => $request->etd_end_date,
        ];

        $origin = null;
        $destination = null;
        $company = null;
        $eta = ['start_date' => $request->eta_start_date, 'end_date' => $request->eta_end_date];
        $etd = ['start_date' => $request->etd_start_date, 'end_date' => $request->etd_end_date];

        $seaSchedulesQuery = SeaSchedule::query();

        if ($request->origin_id) {
            $origin = Location::find($request->origin_id);
            $seaSchedulesQuery->where('origin_id', $request->origin_id);
        }

        if ($request->destination_id) {
            $destination = Location::find($request->destination_id);
            $seaSchedulesQuery->where('destination_id', $request->destination_id);
        }

        if ($request->company_id) {
            $company = Company::find($request->company_id);
            $seaSchedulesQuery->where('company_id', $request->company_id);
        }

        if ($etd['start_date']) {
            $seaSchedulesQuery->whereHas('details', function ($q) use ($etd) {
                $q->whereDate('etd', '>=', $etd['start_date']);
            });
        }
        if ($etd['end_date']) {
            $seaSchedulesQuery->whereHas('details', function ($q) use ($etd) {
                $q->whereDate('etd', '<=', $etd['end_date']);
            });
        }
        if ($eta['start_date']) {
            $seaSchedulesQuery->whereHas('details', function ($q) use ($eta) {
                $q->whereDate('eta', '>=', $eta['start_date']);
            });
        }
        if ($eta['end_date']) {
            $seaSchedulesQuery->whereHas('details', function ($q) use ($eta) {
                $q->whereDate('eta', '<=', $eta['end_date']);
            });
        }

        $companies = Company::whereNotIn('id', config('constants.IGNORED_COMPANIES'))
            ->pluck('name', 'id');

        $seaSchedules = $seaSchedulesQuery->latest()
            ->paginate(self::PER_PAGE)
            ->appends($search_criteria);

        return view('admin.sea_schedules.index',
            compact('seaSchedules', 'companies', 'origin', 'destination', 'company', 'eta', 'etd'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $companies = Company::whereNotIn('id', config('constants.IGNORED_COMPANIES'))
            ->pluck('name', 'id'); // TODO: Filter Companies by their type
        $container_sizes = ContainerSizes::get();
        return view('admin.sea_schedules.create',
            compact('companies', 'container_sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $seaSchedule = new SeaSchedule();
        $seaSchedule->origin_id = $request->origin_id;
        $seaSchedule->destination_id = $request->destination_id;
        $seaSchedule->company_id = $request->company_id;
        $seaSchedule->container_size = $request->container_size;
        $seaSchedule->pickup_charges = $request->pickup_charges;
        $seaSchedule->origin_charges = isset($request->origin_charges_included) ? 0 : $request->origin_charges;
        $seaSchedule->origin_charges_included = isset($request->origin_charges_included) ? 1 : 0;
        $seaSchedule->ocean_freight = $request->ocean_freight;
        $seaSchedule->destination_charges = isset($request->destination_charges_included) ? 0 : $request->destination_charges;
        $seaSchedule->destination_charges_included = isset($request->destination_charges_included) ? 1 : 0;
        $seaSchedule->delivery_charges = $request->delivery_charges;
        $seaSchedule->save();

        $seaSchedule->details()->create([
            'eta' => $request->eta,
            'etd' => $request->etd,
            'valid_till' => $request->valid_till,
            'tt' => $request->tt,
            'ft' => $request->ft,
        ]);

        return redirect()->route('superadmin.sea-schedules.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeaSchedule $seaSchedule)
    {
        $companies = Company::whereNotIn('id', config('constants.IGNORED_COMPANIES'))
            ->pluck('name', 'id'); // TODO: Filter Companies by their type
        $container_sizes = ContainerSizes::get();
        return view('admin.sea_schedules.edit',
            compact('companies', 'container_sizes', 'seaSchedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SeaSchedule $seaSchedule)
    {
        $seaSchedule->origin_id = $request->origin_id;
        $seaSchedule->destination_id = $request->destination_id;
        $seaSchedule->company_id = $request->company_id;
        $seaSchedule->container_size = $request->container_size;
        $seaSchedule->pickup_charges = $request->pickup_charges;
        $seaSchedule->origin_charges = isset($request->origin_charges_included) ? 0 : $request->origin_charges;
        $seaSchedule->origin_charges_included = isset($request->origin_charges_included) ? 1 : 0;
        $seaSchedule->ocean_freight = $request->ocean_freight;
        $seaSchedule->destination_charges = isset($request->destination_charges_included) ? 0 : $request->destination_charges;
        $seaSchedule->destination_charges_included = isset($request->destination_charges_included) ? 1 : 0;
        $seaSchedule->delivery_charges = $request->delivery_charges;
        $seaSchedule->save();

        // Delete details data
        $seaSchedule->details()->delete();

        $seaSchedule->details()->create([
            'eta' => $request->eta,
            'etd' => $request->etd,
            'valid_till' => $request->valid_till,
            'tt' => $request->tt,
            'ft' => $request->ft,
        ]);

        return redirect()->route('superadmin.sea-schedules.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeaSchedule $seaSchedule)
    {
        // Delete details data
        $seaSchedule->details()->delete();

        $seaSchedule->delete();

        return redirect()->route('superadmin.sea-schedules.index');
    }
}
