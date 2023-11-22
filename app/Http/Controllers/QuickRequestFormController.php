<?php

namespace App\Http\Controllers;
use App\Models\QuickRequestForms;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuickRequestFormSubmitted;
use Illuminate\Http\Request;

class QuickRequestFormController extends Controller
{

    const PER_PAGE = 15;

    public function index(Request $request)
    {
        $quick_request_form_query = QuickRequestForms::query();

        $search_criteria = [
            'name' => $request->name,
            'email' => $request->email,
            'company' => $request->company,
            'phone' => $request->phone,
        ];

        $name = $request->input('name');
        $company = $request->input('company');
        $email = $request->input('email');
        $phone = $request->input('phone');

        if ($name) {
            $quick_request_form_query->where(function ($q) use ($name) {
                $q->where('name', 'like', '%' . $name . '%');
            });
        }
    
        if ($email) {
            $quick_request_form_query->where(function ($q) use ($email) {
                $q->where('email', 'like', '%' . $email . '%');
            });
        }
        if ($phone) {
            $quick_request_form_query->where(function ($q) use ($phone) {
                $q->where('phone', 'like', '%' . $phone . '%');
            });
        }
    
        if ($company) {
            $quick_request_form_query->where(function ($q) use ($company) {
                $q->where('company', 'like', '%' . $company . '%');
            });
        }

        // TODO: Add Filters
        $quick_request_forms = $quick_request_form_query->latest()->paginate(self::PER_PAGE);
        return view('admin.quick_request_forms.index', compact('quick_request_forms',  'name', 'email', 'company', 'phone'));
    }


    public function quickRequestDetailsByID(Request $request)
    {
        $quick_request_form_details = QuickRequestForms::find($request->quickRequestID);
        return view('admin.quick_request_forms.detail', compact('quick_request_form_details'));
    }


    public function storeRequestQuoteData(Request $request) 
    {
    
    $rules = [
        'name' => 'required|string',
        'company' => 'required|string',
        'phone' => 'required|string',
        'email' => 'required|email',
        'description' => 'required|string',
        'origin_name' => 'required|string',
        'destination_name' => 'required|string',
        'route_type' => 'required|string',
        'etd' => 'required|string',
        'eta' => 'required|string',
        'booking_company' => 'required|string',
    ];

    $validatedData = $request->validate($rules);
    
    $quickRequestForm = new QuickRequestForms;
    $quickRequestForm->name = $validatedData["name"];
    $quickRequestForm->email= $validatedData["email"];
    $quickRequestForm->phone= $validatedData["phone"];
    $quickRequestForm->company= $validatedData["company"];
    $quickRequestForm->origin_name= $validatedData["origin_name"];
    $quickRequestForm->destination_name= $validatedData["destination_name"];
    $quickRequestForm->description= $validatedData["description"];
    $quickRequestForm->route_type= $validatedData["route_type"];
    $quickRequestForm->etd= $validatedData["etd"];
    $quickRequestForm->eta= $validatedData["eta"];
    $quickRequestForm->booking_company= $validatedData["booking_company"];
    $quickRequestForm->save();

    try {
        $admin_email = env('ADMIN_EMAIL');
        if ($admin_email) {
            Mail::to($admin_email)->queue(new QuickRequestFormSubmitted($quickRequestForm));
        } 
    } catch (\Exception $e) {
        \Log::error('Email sending failed: ' . $e->getMessage());
    }

    if ($quickRequestForm) {
        return response()->json(['message' => 'Your request has been submitted successfully.', 'status' => 'success']);
    } else {
        return response()->json(['message' => 'Record creation failed', 'status' => 'error']);
    }


    }
}
