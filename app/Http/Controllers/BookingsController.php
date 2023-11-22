<?php

namespace App\Http\Controllers;

use App\Mail\BookingCreated;
use App\Models\Booking;
use App\Models\ContainerSizes;
use App\Models\BookingAddon;
use App\Models\Company;
use App\Models\Location;
use App\Models\BookingAddonDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookingsController extends Controller
{
    const PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $companies = Company::pluck('name', 'id');
        $perPage = $request->input('per_page', self::PER_PAGE); // Number of records per page
        $search = $request->input('search'); // Search keyword

        $search_criteria = [
            'origin_id' => $request->origin_id,
            'destination_id' => $request->destination_id,
            'company_id' => $request->company_id,
        ];

        $origin = null;
        $destination = null;
        $company = null;

        if (auth()->user()->role_id == 1) {
            $bookingsQuery = Booking::query();
        } else {
            $bookingsQuery = Booking::where('user_id', Auth::user()->id);
        }

        if ($request->origin_id) {
            $origin = Location::find($request->origin_id);
            $bookingsQuery->where('origin_id', $request->origin_id);
        }

        if ($request->destination_id) {
            $destination = Location::find($request->destination_id);
            $bookingsQuery->where('destination_id', $request->destination_id);
        }

        if ($request->company_id) {
            $company = Company::find($request->company_id);
            $bookingsQuery->where('company_id', $request->company_id);
        }
        
        $bookings = $bookingsQuery->latest()->paginate($perPage)->appends($search_criteria);

        if (auth()->user()->role_id == 1) {
            return view('admin.bookings.index', compact( 'origin', 'destination', 'company','bookings', 'search', 'companies'));
        } else {
            return view('customers.bookings.index', compact( 'origin', 'destination', 'company', 'bookings', 'search', 'companies'));
        }
    }

    public function show(Request $request, Booking $booking)
    {
        if (auth()->user()->role_id == 1) {
            return view('admin.bookings.show', compact("booking"));
        } else if (auth()->user()->role_id == 2 && $booking->user_id === Auth::user()->id) {
            return view('customers.bookings.show', compact("booking"));
        }

        if (auth()->user()->role_id == 1) {
            return redirect()->route('superadmin.bookings.index');
        } else if (auth()->user()->role_id == 2) {
            return redirect()->route('customer.bookings.index');
        } else {
            abort(404);
        }
    }

    public function getContainerSizes()
    {
        $container_sizes = ContainerSizes::get();
        return response()->json([
            "container_sizes" => $container_sizes
        ]);
    }

    public function editBookingDetails(Request $request)
    {
            $booking = Booking::find($request->bookingId);
            return view('admin.bookings.edit', compact("booking"));
  
    }
    
    public function updatebookingDetails(Request $request)
    {

        try {
            $booking = Booking::findOrFail($request->bookingId); 
            $booking->shipping_number = $request->shipping_number;
            $booking->receipt_number = $request->receipt_number;
            $booking->status = $request->status;
            $booking->update();
    
            return redirect()->route('superadmin.bookings.index')->with('success', 'Booking details saved successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with( 'error' , $e->getMessage());
        }

    }
    public function storeShipmentDetails(Request $request)
    {
        $selected_booking_addons = session()->get("addon_details");
        $price_breakdown = session()->get("booking_details");
        $booking_details = $request["booking_details"];
        
        $booking = new Booking;
        try {
            if (!empty($booking_details)) {
                DB::beginTransaction();

                $booking = new Booking;
                $booking->user_id = Auth::user()->id;
                $booking->origin_id = $booking_details["origin"]["id"];
                $booking->destination_id = $booking_details["destination"]["id"];
                $booking->amount = $booking_details["total_amount"] ?? 0;
                $booking->no_of_containers = $booking_details["no_of_containers"];
                $booking->container_size = $booking_details["container_size"]['display_label'] ?? '-';
                $booking->transportation = "Ship";
                $booking->product = "Vegetables";
                $booking->arrival_date_time = Carbon::parse($booking_details["arrival_date_time"]);
                $booking->departure_date_time = Carbon::parse($booking_details["departure_date_time"]);
                $booking->company_id = $booking_details["company"]["id"];
                $booking->status = config('constants.BOOKING_PAYMENT_STATUS_ON_HOLD');

                if(isset($price_breakdown["priceBreakDown"])){
                    $booking->pickup_charges = $price_breakdown["priceBreakDown"]["Pickup Charges"]["value"];
                    $booking->origin_charges = $price_breakdown["priceBreakDown"]["Origin Charges"]["value"];
                    $booking->basic_ocean_freight = $price_breakdown["priceBreakDown"]["BASIC OCEAN FREIGHT"]["value"];
                    $booking->destination_charges = $price_breakdown["priceBreakDown"]["Destination Charges"]["value"];
                    $booking->delivery_charges = $price_breakdown["priceBreakDown"]["Delivery Charges"]["value"];
                    $booking->is_checked_pickup_charges = $price_breakdown["priceBreakDown"]["Pickup Charges"]["isChecked"] ? 'Y' : 'N';
                    $booking->is_checked_origin_charges = $price_breakdown["priceBreakDown"]["Origin Charges"]["isChecked"] ? 'Y' : 'N';
                    $booking->is_checked_basic_ocean_freight = $price_breakdown["priceBreakDown"]["BASIC OCEAN FREIGHT"]["isChecked"] ? 'Y' : 'N';
                    $booking->is_checked_destination_charges = $price_breakdown["priceBreakDown"]["Destination Charges"]["isChecked"] ? 'Y' : 'N';
                    $booking->is_checked_delivery_charges = $price_breakdown["priceBreakDown"]["Delivery Charges"]["isChecked"] ? 'Y' : 'N';
                }
                $booking->save();

                if (!empty($selected_booking_addons)) {
                    foreach ($selected_booking_addons as $addon) {
                        if (($addon["type"] == "toggle" && !empty($addon["is_checked"])) || ($addon["type"] == "counter")) {
                            $booking_addon_details = BookingAddon::find($addon["id"]);

                            $booking_addon = new BookingAddonDetails;
                            $booking_addon->booking_id = $booking->id;
                            $booking_addon->value = $addon["default_value"];
                            $booking_addon->name = $booking_addon_details->name;
                            $booking_addon->type = $booking_addon_details->type;
                            $booking_addon->step = $booking_addon_details->step;
                            $booking_addon->additional_text = $booking_addon_details->additional_text;
                            $booking_addon->save();
                        }
                    }
                }

                session()->forget("booking_details");
                session()->forget("addon_details");
                DB::commit();

                Mail::to($booking->user->email)
                    ->cc(env('ADMIN_EMAIL'))
                    ->queue(new BookingCreated($booking));

                return response()->json([
                    "status" => true,
                    "data" => ['booking' => $booking],
                    "message" => "Booking saved successfully.",
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => "error",
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Some error occurred.",
        ]);
    }

    public function storeInSession(Request $request)
    {
        session()->put('booking_details', $request->all());

        return response()->json([
            "status" => "success",
            "message" => "Booking details saved successfully in session",
        ]);
    }
}
