<?php

namespace App\Http\Controllers;

use App\Models\BookingAddon;
use Illuminate\Http\Request;

class BookingAddonsController extends Controller
{
    const PER_PAGE = 15;

    public function __construct(Request $request)
    {
        if(!in_array(\Illuminate\Support\Facades\Route::currentRouteName(), ['booking-addons.store.in_session'])) {
            $is_route_type_sea = str_contains(\Illuminate\Support\Facades\Route::currentRouteName(), 'sea');

            $request->merge([
                'route_type' => $is_route_type_sea ? ROUTE_TYPE_SEA : ROUTE_TYPE_LAND,
                'route_type_name' => $is_route_type_sea ? "SEA" : 'LAND',
                'route_type_addition' => $is_route_type_sea ? "sea" : 'land',
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bookingAddonsQuery = BookingAddon::where('route_type', $request->route_type);
        // TODO: Add Filters
        $bookingAddons = $bookingAddonsQuery->latest()->paginate(self::PER_PAGE);
        return view('admin.booking_addons.index', compact('bookingAddons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.booking_addons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $booking_addon = new BookingAddon();
        $booking_addon->name = $request->name;
        $booking_addon->type = $request->type;
        $booking_addon->additional_text = $request->additional_text;
        $booking_addon->default_value = $request->default_value;
        $booking_addon->step = $request->type === 'counter' ? $request->step : NULL;
        $booking_addon->status = isset($request->status);
        $booking_addon->route_type = $request->route_type;
        $booking_addon->save();

        return $this->redirectToIndex($request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, BookingAddon $booking_addon)
    {
        // Check that Route is editing in Correct type forms
        $this->verifyAddonRouteType($request, $booking_addon);

        return view('admin.booking_addons.edit', compact("booking_addon"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookingAddon $booking_addon)
    {
        $booking_addon->name = $request->name;
        $booking_addon->type = $request->type;
        $booking_addon->additional_text = $request->additional_text;
        $booking_addon->default_value = $request->default_value;
        $booking_addon->step = $request->type === 'counter' ? $request->step : NULL;
        $booking_addon->status = $request->status;
        $booking_addon->save();

        return $this->redirectToIndex($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, BookingAddon $booking_addon)
    {
        // Check that Route is editing in Correct type forms
        $this->verifyAddonRouteType($request, $booking_addon);

        $booking_addon->delete();

        return $this->redirectToIndex($request);
    }

    public function storeInSession(Request $request)
    {
        session()->put('addon_details', $request->all());

        return response()->json([
            "status" => "success",
            "message" => "Addon details saved successfully in session",
        ]);
    }

    private function redirectToIndex(Request $request)
    {
        if ($request->route_type === ROUTE_TYPE_SEA) {
            $redirect_to = 'superadmin.sea-booking-addons.index';
        } else {
            $redirect_to = 'superadmin.land-booking-addons.index';
        }

        return redirect()->route($redirect_to);
    }

    private function verifyAddonRouteType(Request $request, BookingAddon $booking_addon)
    {
        if ($booking_addon->route_type != $request->route_type) {
            abort(404);
        }
    }
}
