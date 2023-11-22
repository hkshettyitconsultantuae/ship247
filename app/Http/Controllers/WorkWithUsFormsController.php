<?php

namespace App\Http\Controllers;

use App\Mail\WorkWithUsFormSubmitted;
use App\Models\WorkWithUsForm;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WorkWithUsFormsController extends Controller
{
    const PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $work_with_us_forms_query = WorkWithUsForm::query();

        $search_criteria = [
            'name' => $request->name,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'contact_number' => $request->contact_number,
            'industry' => $request->industry,
        ];

        $name = $request->input('name');
        $company_name = $request->input('company_name');
        $email = $request->input('email');
        $industry = $request->input('industry');
        $contact_number = $request->input('contact_number');

        if ($name) {
            $work_with_us_forms_query->where(function ($q) use ($name) {
                 // Split the full name into first name and last name
                $searchTerms = explode(' ', $name);
                $firstName = $searchTerms[0];
                $lastName = count($searchTerms) > 1 ? $searchTerms[1] : null;
        
                $q->where(function ($fullNameQuery) use ($firstName, $lastName) {
                        $fullNameQuery->where('first_name', 'like', '%' . $firstName . '%')
                                    ->where('last_name', 'like', '%' . $lastName . '%');
                    });
                    // Add a separate condition for searching by last name only
                    $q->orWhere('last_name', 'like', '%' . $name . '%');
            });
           
        }
    
        if ($email) {
            $work_with_us_forms_query->where(function ($q) use ($email) {
                $q->where('email', 'like', '%' . $email . '%');
            });
        }
        if ($contact_number) {
            $work_with_us_forms_query->where(function ($q) use ($contact_number) {
                $q->where('phone_number', 'like', '%' . $contact_number . '%');
            });
        }
        if ($industry) {
            $work_with_us_forms_query->where(function ($q) use ($industry) {
                $q->where('industry', 'like', '%' . $industry . '%');
            });
        }
        if ($company_name) {
            $work_with_us_forms_query->where(function ($q) use ($company_name) {
                $q->where('company_name', 'like', '%' . $company_name . '%');
            });
        }



        // TODO: Add Filters
        $work_with_us_forms = $work_with_us_forms_query->latest()->paginate(self::PER_PAGE);
        return view('admin.work_with_us_forms.index', compact('work_with_us_forms',  'name', 'email', 'company_name', 'industry', 'contact_number'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function workWithUsFormDetailsByID(Request $request)
    {
        $work_with_us_form_details = WorkWithUsForm::find($request->workWithUsFormID);
        $industries = Industry::pluck('name')->toArray();
        return view('admin.work_with_us_forms.detail', compact('work_with_us_form_details', 'industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateStatus(Request $request)
    {
        WorkWithUsForm::where('id' , $request->id)->update(['status' => $request->status, 'industry' => (is_array($request->industry) && count($request->industry)
        ? implode(',', $request->industry) : '')]);
        return redirect()->back()->with('success', 'Work with us form status updated successfully.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'phone_number' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'company_name' => ['required', 'max:255'],
            'industry' => ['required', 'array'],
        ]);

        $selected_industries = Industry::whereIn('id', $request->industry)->pluck('name')->toArray();
        $form = new WorkWithUsForm;
        $form->first_name = $request->first_name;
        $form->last_name = $request->last_name;
        $form->phone_number = $request->phone_number;
        $form->email = $request->email;
        $form->company_name = $request->company_name;
        $form->industry = is_array($selected_industries) && count($selected_industries)
            ? implode(',', $selected_industries) : '';
      
        $form->save();

        // Send EMail
        $admin_email = env('ADMIN_EMAIL');
        if($admin_email) {
            Mail::to($admin_email)->queue(new WorkWithUsFormSubmitted($form));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkWithUsForm $workWithUsForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkWithUsForm $workWithUsForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkWithUsForm $workWithUsForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkWithUsForm $workWithUsForm)
    {
        //
    }
}
