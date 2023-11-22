<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Company;
use App\Models\Country;
use Inertia\Inertia;
use Inertia\Response;
use DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function getUserDetails(Request $request)
    {
        if (Auth::user()) {
            return response()->json([
                "isAuthenticated" => true,
                "user_details" => Auth::user(),
            ]);
        } else {
            return response()->json([
                "isAuthenticated" => false,
            ]);
        }
    }

    public function getUserList(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Number of records per page
        $search = $request->input('search'); // Search keyword

        $search_criteria = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        $name = $request->input('name');
        $email = $request->input('email');

           $userQuery = User::where('role_id', 3);
           if ($name) {
                $userQuery->where(function ($nameQuery) use ($name) {
                // Split the full name into first name and last name
                $searchTerms = explode(' ', $name);
                $firstName = $searchTerms[0];
                $lastName = count($searchTerms) > 1 ? $searchTerms[1] : null;
        
                $nameQuery->where(function ($fullNameQuery) use ($firstName, $lastName) {
                    $fullNameQuery->where('first_name', 'like', '%' . $firstName . '%')
                                  ->where('last_name', 'like', '%' . $lastName . '%');
                });
                 // Add a separate condition for searching by last name only
                 $nameQuery->orWhere('last_name', 'like', '%' . $name . '%');
            });
               
        }
        
        if ($email) {
            $userQuery->where(function ($emailQuery) use ($email) {
                $emailQuery->where('email', 'like', '%' . $email . '%');
            });
        }

        $users = $userQuery->latest()->paginate($perPage)->appends($search_criteria);

        return view('admin.users.index', compact("users", 'name', 'email' ));
    }

    public function storeUser(Request $request)
    {
        // try{
        DB::beginTransaction();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // 'country' => 'required|string|max:255',
            // 'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->role_id = 3;
        // $user->country = $request->input('country');
        // $user->company_name = $request->input('company_name');
        $user->phone_number = $request->input('phone_number');
        // $user->vat = "TEST";
        $user->position = $request->input('position');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        DB::commit();

        // }
        // catch (\Exception $e){
        //     DB::rollback();
        //     return redirect()->route('superadmin.user.create')->with('error', $e->getMessage());
        // }

        return redirect()->route('superadmin.user.index')->with('success', 'User Created!');
    }

    public function updateUser(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                // 'country' => 'required|string|max:255',
                // 'company_name' => 'required|string|max:255',
                // 'industry' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone_number' => 'required|string|max:20',
                'password' => 'confirmed',
            ]);

            $user = User::find($request->user_id);
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->role_id = 3;
            $user->country = $request->input('country');
            $user->position = $request->input('position');
            $user->phone_number = $request->input('phone_number');
            if ($request->input('password') != null) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->save();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('superadmin.user.index')->with('success', 'Employee Updated!');
    }

    public function getCustomerDetails(Request $request)
    {
        $customer_details = User::find($request->customerID);
        $companies = Company::where('status', config('constants.COMPANY_REGISTRATION_STATUS_APPROVED'))->get();
        return view('admin.customers.detail', compact("customer_details", "companies"));
    }

    public function createUser(Request $request)
    {
        $countries = Country::all();
        return view('admin.users.create', compact('countries'));
    }

    public function editUser(Request $request)
    {
        $user = User::find($request->userID);

        $countries = Country::all();
        return view('admin.users.edit', compact('countries', 'user'));
    }

    public function getCustomerList(Request $request)
    {
        $perPage = $request->input('per_page', 15); // Number of records per page
        $search = $request->input('search'); // Search keyword

        $search_criteria = [
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
        ];

        $name = $request->input('name');
        $email = $request->input('email');
        $contact_number = $request->input('contact_number');

           $customerQuery = User::where('role_id', 2);
           if ($name) {
                $customerQuery->where(function ($nameQuery) use ($name) {
                // Split the full name into first name and last name
                $searchTerms = explode(' ', $name);
                $firstName = $searchTerms[0];
                $lastName = count($searchTerms) > 1 ? $searchTerms[1] : null;
        
                $nameQuery->where(function ($fullNameQuery) use ($firstName, $lastName) {
                    $fullNameQuery->where('first_name', 'like', '%' . $firstName . '%')
                                  ->where('last_name', 'like', '%' . $lastName . '%');
                });
                 // Add a separate condition for searching by last name only
                 $nameQuery->orWhere('last_name', 'like', '%' . $name . '%');
            });
               
        }
        
        if ($email) {
            $customerQuery->where(function ($emailQuery) use ($email) {
                $emailQuery->where('email', 'like', '%' . $email . '%');
            });
        }
        
        if ($contact_number) {
            $customerQuery->where(function ($contactNumberQuery) use ($contact_number) {
                $contactNumberQuery->where('phone_number', 'like', '%' . $contact_number . '%');
            });
        }

        $customers = $customerQuery->latest()->paginate($perPage)->appends($search_criteria);

        return view('admin.customers.index', compact("customers", "search", 'name', 'email' ,'contact_number'));
    }

    public function getLoggedInUserProfilePage(Request $request)
    {
        $user = auth()->user();
        if ($user->role_id == 1) {
            return view('admin.profile', compact("user"));
        } else if ($user->role_id == 2) {
            return view('customers.profile', compact("user"));
        }
        return false;
    }

    public function updateProfilePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        if ($user->role_id == 1) {
            return redirect()->route('superadmin.profile')->with('status', 'Password updated successfully');
        } else {
            return redirect()->route('customer.profile')->with('status', 'Password updated successfully');
        }
    }

    public function updateProfileInformation(Request $request)
    {
        // try{
        DB::beginTransaction();
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            // 'company_name' => 'required|string|max:255',
            // 'industry' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        if (!isset($request->userID)) {
            $request->validate([
                'password' => 'confirmed',
            ]);
        }

        $user = auth()->user();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        if (!isset($request->userID)) {
            $user->email = $request->input('email');
        }
        $user->phone_number = $request->input('phone_number');
        $user->country = $request->input('country');

        if (isset($request->userID)) {
            $user->city = $request->input('city');
            $user->department = $request->input('department');
            $user->job_title = $request->input('job_title');
        }

        // $user->company_name = $request->input('company_name');
        // $user->vat = "TEST";
        // $user->industry = $request->input('industry');
        if ($request->input('password') != null) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        DB::commit();

        // }
        // catch (\Exception $e){
        //     DB::rollback();
        //     return redirect()->route('superadmin.user.create')->with('error', $e->getMessage());
        // }

        if ($user->role_id == 1) {
            return view('admin.profile', compact("user"));
        } else {
            return view('customers.profile', compact("user"));
        }
    }

    public function deleteUser(Request $request)
    {
        $user = User::find($request->userID);
        $user->delete();

        return redirect()->route('superadmin.user.index');
    }

    public function deleteCustomer(Request $request)
    {
        $customer = User::find($request->customerID);
        $customer->delete();

        return redirect()->route('superadmin.customers.index')->with('success', 'Customer Deleted!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
