<?php

namespace App\Http\Controllers;

use App\Models\TruckType;
use Illuminate\Http\Request;

class TruckTypesController extends Controller
{

    const PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $truck_type_query = TruckType::query();
        // TODO: Add Filters
        $truck_types = $truck_type_query->latest()->paginate(self::PER_PAGE);
        return view('admin.truck_types.index', compact('truck_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.truck_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $truckType = new TruckType();
        $truckType->display_label = $request->display_label;
        $truckType->save();

        return redirect()->route('superadmin.truck-types.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TruckType $truckType)
    {
        return view('admin.truck_types.edit', compact('truckType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TruckType $truckType)
    {
        $truckType->display_label = $request->display_label;
        $truckType->save();

        return redirect()->route('superadmin.truck-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TruckType $truckType)
    {
        $truckType->delete();

        return redirect()->route('superadmin.truck-types.index');
    }

    public function getApi()
    {
        $truck_types = TruckType::select('display_label', 'id')->get()->toArray();
        return response()->json([
            "truck_types" => $truck_types
        ]);
    }
}
