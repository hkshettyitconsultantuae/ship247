<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
  
        if(auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')){
            

            $perPage = $request->input('per_page', 10); // Number of records per page
            $search = $request->input('search'); // Search keyword
            
            if (auth()->user()->role_id == 1) {
                $bookingsQuery = Booking::query();
            } else {
                $bookingsQuery = Booking::where('user_id', auth()->user()->id);
            }
            if ($search) {
                $bookingsQuery->where(function ($query) use ($search) {
                    $query->where(function ($subQuery) use ($search) {
                        $subQuery->whereHas('destination', function ($destinationQuery) use ($search) {
                            $destinationQuery->where('city', 'like', '%' . $search . '%')
                                            ->orWhere('code', 'like', '%' . $search . '%')  
                                            ->orWhereHas('country', function ($countryQuery) use ($search) {
                                               $countryQuery->where('name', 'like', '%' . $search . '%');
                                           });
                        })->orWhereHas('origin', function ($originQuery) use ($search) {
                            $originQuery->where('city', 'like', '%' . $search . '%')
                            ->orWhere('code', 'like', '%' . $search . '%')  
                                        ->orWhereHas('country', function ($countryQuery) use ($search) {
                                            $countryQuery->where('name', 'like', '%' . $search . '%');
                                        });
                        })->orWhereHas('company', function ($companyQuery) use ($search) {
                            $companyQuery->where('name', 'like', '%' . $search . '%');
                        });
                    })->orWhere('container_size', 'like', '%' . $search . '%')
                      ->orWhere('product', 'like', '%' . $search . '%')
                      ->orWhere('status', 'like', '%' . $search . '%')
                      ->orWhere('id', 'like', '%' . $search . '%');
                });
            }
            $bookings = $bookingsQuery->latest()->paginate($perPage);

            $data = [
                "total_bookings" => Booking::count(),
                "total_earnings" => Booking::where("status", "ON-HOLD")->sum('amount'),
                "registered_users" => User::where('role_id', config('constants.USER_TYPE_CUSTOMER'))->count(),
                "in_progress_bookings" => Booking::where("status", "IN-PROGRESS")->count(),
                "on_hold_bookings" => Booking::where("status", "ON-HOLD")->count(),
                "bookings" => $bookings,
                "search" => $search,

            ];
            return view('admin.dashboard' , compact('data'));
        } 
        else if(auth()->user()->role_id == config('constants.USER_TYPE_CUSTOMER')){
            $data = [
                "total_bookings" => Booking::where('user_id', auth()->user()->id )->count(),
                "in_progress_bookings" => Booking::where('user_id', auth()->user()->id )->where("status", "IN-PROGRESS")->count(),
                "on_hold_bookings" => Booking::where('user_id', auth()->user()->id )->where("status", "ON-HOLD")->count(),
            ];
            return view('customers.dashboard' , compact('data'));
        }
     
    }

}
