@extends('layouts.admin')
<?php 
if($company_details !== null ){
if (isset($company_details->industry) && $company_details->industry !== null) {
    $company_details->industry = explode(',', $company_details->industry);
} else {
    $company_details->industry = [];
}
}
?>
@section('content')

<section class="shadow-box small-box mt-8">
    <div class="dashboard-detail-box">

        <header>
            <div class="w-9/12">
                <h2 class="title">
                    Company Registration
                </h2>
            </div>

            <div class="w-3/12">
                <p class="primary-color primary-font-medium text-right">
                    Account Type: <span class="primary-font-regular">Shipper</span>
                </p>
            </div>
        </header>

        @if(isset($company_details) && $company_details->status ==
        config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT') && $company_details->message !=null )
        <p class="bg-yellow-300 px-4 py-2 rounded-md mt-8"><strong>Message: </strong> {{$company_details->message}}</p>
        @endif

        <div class="mt-14">
            <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4 ">
                <p class="text-sm primary-font-medium primary-color uppercase">company information</p>

                <div>
                    @if(isset($company_details))

                    @if($company_details->status == config("constants.COMPANY_REGISTRATION_STATUS_PENDING") )
                    <span class="badge progress">
                        PENDING Approval
                    </span>
                    @endif
                    @if($company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_APPROVED'))
                    <span class="badge completed">
                        APPROVED
                    </span>
                    @endif
                    @if($company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT'))
                    <span class="badge cancel">
                        RESUBMIT request
                    </span>
                    @endif

                    @endif
                </div>
            </div>
        </div>


        <form id="user-form" method="POST" action="{{ route('company.store') }}"
            class="default-form {{ isset($company_details->status) && ($company_details->status == config("
            constants.COMPANY_REGISTRATION_STATUS_PENDING") || $company_details->status ==
            config('constants.COMPANY_REGISTRATION_STATUS_APPROVED')) ? 'disabled-form' :
            ''}}"
            enctype="multipart/form-data">
            @csrf

            <div class="company-section">

                <div class="flex">
                    {{-- <div class="w-2/12">
                        <p>
                            <span class="uppercase text-gray-400 text-xs block">id</span>
                            <span class="primary-color primary-font-medium block mt-2">{{isset($company_details) ?
                                str_pad($company_details->id, 5, '0', STR_PAD_LEFT) : ''}}</span>
                        </p>
                    </div> --}}

                    @if(isset($company_details))
                    <input type="hidden" name="companyID" value="{{$company_details->id}}" />
                    @endif

                    <div class="w-9/12">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="form-field">
                                <label for="company_name" class="uppercase text-gray-400 text-xs block">Company
                                    Name</label>
                                <input required type="text" id="company_name" name="company_name"
                                    value="{{ old('company_name', isset($company_details) ? $company_details->name : '') }}"
                                    class="form-input small-input mt-2 w-9/12 block">
                                @error('company_name')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="industry" class="uppercase text-gray-400 text-xs block">business
                                    type</label>
                                    <select name="industry[]" id="industry" multiple required class="form-input small-input mt-2 w-9/12 block select-multiple">
                                        @if ( isset($industries) && count($industries) > 0)
                                            @foreach ($industries as $option)
                                                <option value="{{ $option->name }}" 
                                                    {{ $company_details && is_array($company_details->industry) && in_array($option->name, $company_details->industry) ? 'selected' : '' }}>
                                                    {{ $option->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                @error('industry')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="email"
                                    class="uppercase text-gray-400 text-xs flex-inline items-center">corporate
                                    email</label>
                                <input required
                                    value="{{old('email', isset($company_details) ? $company_details->email : '' )}}"
                                    type="text" id="email" name="email"
                                    class="form-input small-input mt-2 w-9/12 block">
                                @error('email')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="contact_no" class="uppercase text-gray-400 text-xs block">corporate
                                    contact</label>
                                <input
                                    value="{{old('contact_no', isset($company_details) ? $company_details->contact_no : '') }}"
                                    required type="tel" id="contact_no" name="contact_no"
                                    class="form-input small-input mt-2 w-9/12 block">
                                @error('contact_no')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="country" class="uppercase text-gray-400 text-xs block">country</label>
                                <select name="country" id="country" required
                                    class="form-input small-input mt-2 w-9/12 block">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country )
                                    <option <?php echo old('country', isset($company_details) && $company_details->
                                        country ==
                                        $country->name ? 'selected' : '') ?>
                                        value="{{$country->name}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="city" class="uppercase text-gray-400 text-xs block">city</label>
                                <input value="{{old('city',  isset($company_details) ? $company_details->city : '')}}"
                                    required type="text" id="city" name="city"
                                    class="form-input small-input mt-2 w-9/12 block">
                                @error('city')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="website" class="uppercase text-gray-400 text-xs block">website</label>
                                <input
                                    value="{{old('website', isset($company_details) ? $company_details->website : '') }}"
                                    type="text" id="website" name="website"
                                    class="form-input small-input mt-2 w-9/12 block">
                                @error('website')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="about" class="uppercase text-gray-400 text-xs block">about</label>
                                <input
                                    value="{{old('about',isset($company_details) ? $company_details->description : '') }}"
                                    type="text" id="about" name="about"
                                    class="form-input small-input mt-2 w-9/12 block">
                                @error('about')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="document-section mt-14">
                <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
                    <p class="text-sm primary-font-medium primary-color uppercase">documents </p>
                </div>
                @if(isset($company_details) && $company_details->status ==
                config("constants.COMPANY_REGISTRATION_STATUS_RESUBMIT") )
                <div class="w-9/12">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Document Type</span>
                            <select name="document_type" class="form-input small-input mt-2 w-9/12 block" <?php echo
                                (isset($company_details) && $company_details->status ==
                                config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT')) ? '' : 'required' ?> >
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
                            <input type="file" name="documents[]" id="documents" class="mt-4 w-9/12"
                                accept="application/pdf" multiple <?php echo (isset($company_details) &&
                                $company_details->status ==
                            config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT')) ? '' : 'required' ?> />

                            @error('documents')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                @endif

                <div class="detail-body">
                    @if(isset($company_details) && isset($company_details->documents) &&
                    count($company_details->documents) > 0 )
                    @foreach ( $company_details->documents as $option)
                    <?php $result = array_filter(config('constants.COMPANY_DOCUMENTS'), function($item) use ($option) {
                        return $item->value == $option->type;
                    });
                    $matchingObject = reset($result);
                    ?>
                    <div class="detail-box relative items-center">
                        <div class="w-3/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Document Type</span>
                                    @if (!empty($result))
                                    <span class="value">{{ $matchingObject->label}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="w-4/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Document Name</span>
                                    @if (!empty($result))
                                    <a href="{{ asset('storage/'.$option->path)}}" class="value" target="_blank">{{
                                        $option->name
                                        }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="w-3/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Uploaded Date</span>
                                    <span class="value">{{$option->created_at}}</span>
                                </div>
                            </div>
                        </div>

                        @if(!isset($company_details) || (isset($company_details) && $company_details->status ==
                        config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT') ))
                        <div class="w-2/12">
                            <div class="flex justify-end">
                                <a href="#" class="default-button-v2 small-button outline-button delete-btn">
                                    <span>Delete</span>
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                    @elseif(!isset($company_details))
                    <div class="w-9/12">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">Document Type</span>
                                <select name="document_type" id="" class="form-input small-input mt-2 w-9/12 block"
                                    <?php echo (isset($company_details) && $company_details->status ==
                                    config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT')) ? '' : 'required' ?> >
                                    <option value="">Select Document</option>
                                    @foreach (config('constants.COMPANY_DOCUMENTS') as $option)
                                    <option value="{{$option->value}}">{{$option->label}}</option>
                                    @endforeach
                                </select>
                                @error('company_name')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">Upload Document</span>
                                <input multiple type="file" name="documents[]" id="documents" class="mt-4 w-9/12"
                                    accept="application/pdf" <?php echo (isset($company_details) &&
                                    $company_details->status ==
                                config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT')) ? '' : 'required' ?> />

                                @error('documents')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if( !isset($company_details) || (isset($company_details) && $company_details->status ==
            config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT') ) )
            <div class="form-field mt-8 text-right">
                <button type="submit" class="default-button-v2">
                    <span>Submit</span>
                </button>
            </div>
            @endif
        </form>

    </div>
</section>

@endsection