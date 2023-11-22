<?php

namespace App\Http\Controllers;

use App\Imports\PickAndDeliverySchedulesImport;
use App\Models\Company;
use App\Models\ContainerSizes;
use App\Models\PickAndDeliverySchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PickAndDeliverySchedulesController extends Controller
{
    const PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pickAndDeliverySchedulesQuery = PickAndDeliverySchedule::query();
        // TODO: Add Filter
        $pickAndDeliverySchedules = $pickAndDeliverySchedulesQuery->latest()
            ->paginate(self::PER_PAGE);
        return view('admin.pick_and_delivery_schedules.index', compact('pickAndDeliverySchedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::whereNotIn('id', config('constants.IGNORED_COMPANIES'))
            ->pluck('name', 'id'); // TODO: Filter Companies by their type
        $container_sizes = ContainerSizes::get();
        return view('admin.pick_and_delivery_schedules.create',
            compact('companies', 'container_sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pickAndDeliverySchedule = new PickAndDeliverySchedule();
        $pickAndDeliverySchedule->origin_id = $request->origin_id;
        $pickAndDeliverySchedule->destination_id = $request->destination_id;
        $pickAndDeliverySchedule->company_id = $request->company_id;
        $pickAndDeliverySchedule->container_size = $request->container_size;
        $pickAndDeliverySchedule->price = $request->price;
        $pickAndDeliverySchedule->valid_till = $request->valid_till;
        $pickAndDeliverySchedule->save();

        return redirect()->route('superadmin.pick-and-delivery-schedules.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PickAndDeliverySchedule $pickAndDeliverySchedule)
    {
        $companies = Company::whereNotIn('id', config('constants.IGNORED_COMPANIES'))
            ->pluck('name', 'id'); // TODO: Filter Companies by their type
        $container_sizes = ContainerSizes::get();
        return view('admin.pick_and_delivery_schedules.edit',
            compact('companies', 'container_sizes', 'pickAndDeliverySchedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PickAndDeliverySchedule $pickAndDeliverySchedule)
    {
        $pickAndDeliverySchedule->origin_id = $request->origin_id;
        $pickAndDeliverySchedule->destination_id = $request->destination_id;
        $pickAndDeliverySchedule->company_id = $request->company_id;
        $pickAndDeliverySchedule->container_size = $request->container_size;
        $pickAndDeliverySchedule->price = $request->price;
        $pickAndDeliverySchedule->valid_till = $request->valid_till;
        $pickAndDeliverySchedule->save();

        return redirect()->route('superadmin.pick-and-delivery-schedules.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PickAndDeliverySchedule $pickAndDeliverySchedule)
    {
        $pickAndDeliverySchedule->delete();

        return redirect()->route('superadmin.pick-and-delivery-schedules.index');
    }

    public function import(Request $request)
    {
        try {
            $pickAndDeliverySchedulesImport = new PickAndDeliverySchedulesImport;
            $pickAndDeliverySchedulesImport->import(
                $request->file('import_file'),
                'local',
                \Maatwebsite\Excel\Excel::XLSX);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            Log::debug($failures);
//            foreach ($failures as $failure) {
//                $failure->row(); // row that went wrong
//                $failure->attribute(); // either heading key (if using heading row concern) or column index
//                $failure->errors(); // Actual error messages from Laravel validator
//                $failure->values(); // The values of the row that has failed.
//            }
        }

        return redirect()->route('superadmin.pick-and-delivery-schedules.index',
            ['imported_rows' => $pickAndDeliverySchedulesImport->imported_rows_count]);
    }
}
