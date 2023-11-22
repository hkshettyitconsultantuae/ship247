@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-6/12">
                <h2 class="title">
                    Create Company
                </h2>
            </div>
            
            <div class="md:w-6/12 md:justify-end flex">
                <a href="" class="default-button-v2 outline-button">
                    <span>Back</span>
                </a>
            </div>
        </header>

        <div class="company-section">
            <div class="">
                <form method="POST" action="{{ route('company.store') }}" class="default-form" id="company-form" enctype="multipart/form-data">
                    @csrf
                    <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4 mt-14">
                        <p class="text-sm primary-font-medium primary-color uppercase">personal information</p>
                    </div>
                    <input type="hidden" name="user_id" value="new_user"/>
                    <section class="w-8/12">
                        <div class="grid grid-cols-2 gap-8 mt-6">
                            <div class="form-field">
                                <label for="first_name" class="form-label">First Name</label>
                                <input name="first_name" type="text" id="first_name" class="form-input small-input w-full" required>
                            </div>
        
                            <div class="form-field">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input name="last_name" type="text" id="last_name" class="form-input small-input w-full" required>
                            </div>
        
                            <div class="form-field">
                                <label for="user_country">Country</label>
                                <select name="user_country" id="user_country" class="form-input small-input w-full" required>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
        
                            <div class="form-field">
                                <label for="user_phone_number" class="form-label">Phone Number</label>
                                <input name="user_phone_number" type="text" id="user_phone_number" class="form-input small-input w-full" required>
                            </div>
        
                            <div class="form-field">
                                <label for="user_email" class="form-label">Email</label>
                                <input name="user_email" type="email" id="user_email" class="form-input small-input w-full" required>
                            </div>
        
                            <div class="form-field">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-input small-input w-full" required>
                            </div>
                        </div>
                    </section>
        
                    <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4 mt-14">
                        <p class="text-sm primary-font-medium primary-color uppercase">company information</p>
                    </div>
        
                    <section class="w-8/12">
                        <div class="grid grid-cols-2 gap-8 mt-6">
                            <div class="form-field">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" name="company_name" id="company_name" class="form-input small-input w-full" required>
                            </div>
        
                            <div class="form-field">
                                <label for="industry" class="form-label">Business Type</label>
                                {{-- <input type="text" name="industry" id="industry" class="form-input small-input w-full" required> --}}
                                <select name="industry[]" multiple id="industry" required
                                class="form-input small-input mt-2 w-9/12 block select-multiple">
                                @if(isset($industries) && count($industries) > 0)
                                @foreach ($industries as $option)
                                <option <?php echo isset($company_details->industry_id) && $company_details->industry_id ==
                                    $option->id ? 'selected' : '' ?> value="{{ $option->id }}">{{
                                    $option->name }}</option>
                                @endforeach
                                @endif
                     
                            </select>
                            </div>
        
                            <div class="form-field">
                                <label for="email" class="form-label">Corporate Email</label>
                                <input type="email" name="email" id="email" class="form-input small-input w-full" required>
                            </div>
        
                            <div class="form-field">
                                <label for="contact_no" class="form-label">Corporate Contact</label>
                                <input type="text" name="contact_no" id="contact_no" class="form-input small-input w-full" required>
                            </div>
        
                            <div class="form-field">
                                <label for="country">Country</label>
                                <select name="country" id="country" class="form-input small-input w-full" required>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
        
                            <div class="form-field">
                                <label for="city" class="form-label">City</label>
                                <input name="city" type="text" id="city" class="form-input small-input w-full" required>
                            </div>
                        </div>
                    </section>

                    <div class="document-section mt-14">
                        <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
                            <p class="text-sm primary-font-medium primary-color uppercase">documents </p>
                        </div>
                  
                        <div class="w-9/12">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Document Type</span>
                                    <select name="document_type" class="form-input small-input mt-2 w-9/12 block" required >
                                        <option value="">Select Document</option>
                                        @foreach (config('constants.COMPANY_DOCUMENTS') as $option)
                                        <option value="{{$option->value}}">{{$option->label}}</option>
                                        @endforeach
                                    </select>
                                    @error('document_type')
                                    <span class="error-field">{{ $message }}</span>
                                    @enderror
                                </div>
        
                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Upload Document</span>
                                    <input type="file" name="documents[]" id="documents" class="mt-4 w-9/12" accept="application/pdf" required multiple />
                                    @error('documents')
                                     <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                
                    </div>
        
                    <div class="form-field mt-8">
                        <button type="submit" class="default-button-v2">
                            <span>Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</section>

@endsection