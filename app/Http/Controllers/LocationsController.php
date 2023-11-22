<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    const PER_PAGE = 15;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $locationsQuery = Location::query();
        // TODO: Add Filters

        $search_criteria = [
            'country' => $request->country,
            'city' => $request->city,
            'port' => $request->port,
            'code' => $request->code,
            'geo_id' => $request->geo_id,
        ];

        $country = $request->input('country');
        $city = $request->input('city');
        $port = $request->input('port');
        $code = $request->input('code');
        $geo_id = $request->input('geo_id');

        if ($country) {
            $locationsQuery->orWhereHas('country', function ($countryQuery) use ($country) {
                    $countryQuery->where('name', 'like', '%' . $country . '%');
            });
        }
   
        if ($city) {
            $locationsQuery->where(function ($nameQuery) use ($city) {
                $nameQuery->where('city', 'like', '%' . $city . '%');
            });
        }

        if ($port) {
            $locationsQuery->where(function ($portQuery) use ($port) {
                $portQuery->where('port', 'like', '%' . $port . '%');
            });
        }
        if ($code) {
            $locationsQuery->where(function ($codeQuery) use ($code) {
                $codeQuery->where('code', 'like', '%' . $code . '%');
            });
        }
        if ($geo_id) {
            $locationsQuery->where(function ($geoIdQuery) use ($geo_id) {
                $geoIdQuery->where('maersk_geo_id', 'like', '%' . $geo_id . '%');
            });
        }


        $locations = $locationsQuery->latest()->paginate(self::PER_PAGE);
        return view('admin.locations.index', compact('locations', 'country','city','port','code','geo_id' ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $countries = Country::pluck('name', 'id');
        return view('admin.locations.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $location = new Location;
        $location->country_id = $request->country_id;
        $location->city = $request->city;
        $location->port = $request->port;
        $location->code = $request->code;
        $location->maersk_geo_id = $request->maersk_geo_id;
        $location->save();

        return redirect()->route('superadmin.locations.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Location $location)
    {
        $countries = Country::pluck('name', 'id');
        return view('admin.locations.edit', compact('location', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $location->country_id = $request->country_id;
        $location->city = $request->city;
        $location->port = $request->port;
        $location->code = $request->code;
        $location->maersk_geo_id = $request->maersk_geo_id;
        $location->save();

        return redirect()->route('superadmin.locations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Location $location)
    {
        $location->delete();

        return redirect()->route('superadmin.locations.index');
    }
}
