@extends('layouts.admin')

@section('content')

<section class="shadow-box small-box mt-8">
    <div class="dashboard-detail-box">

        <header>
            <h2 class="title">
                Customer Detail
                {{-- {{ $customer_details->first_name }} --}}
            </h2>
            <a href="{{route('superadmin.customers.index')}}" class="default-button-v2 outline-button">
                <span>Back</span>
            </a>
        </header>

        @if(isset($customer_details))
        <div class="profile-section mt-14">

            <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
                <p class="text-sm primary-font-medium primary-color uppercase">personal information</p>

                <p class="primary-color primary-font-medium text-right">
                    Account Type: <span class="primary-font-regular">Individual</span>
                </p>
            </div>


            <div class="flex">
                <div class="w-2/12">
                    <p>
                        <span class="uppercase text-gray-400 text-xs block">id</span>
                        <span class="primary-color primary-font-medium block mt-2">{{ $customer_details->id }}</span>
                    </p>
                </div>

                <div class="w-8/12">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">first name</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $customer_details->first_name }}</span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">last name</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $customer_details->last_name }}</span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs flex-inline items-center">email</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $customer_details->email }}</span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">phone number</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $customer_details->phone_number }}</span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">country</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $customer_details->country }}</span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">city</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $customer_details->city }}</span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">department</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $customer_details->department }}</span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">job title</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $customer_details->job_title }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="non-company-verified">
            <div class="company-section mt-14">
                <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4 ">
                    <p class="text-sm primary-font-medium primary-color uppercase">company information</p>

                    @if(isset($customer_details->company))
                    <div>
                        @if($customer_details->company->status ==
                        config('constants.COMPANY_REGISTRATION_STATUS_APPROVED') )
                        <span class="badge completed">
                            Verified
                        </span>
                        @endif
                        @if($customer_details->company->status ==
                        config('constants.COMPANY_REGISTRATION_STATUS_PENDING') )
                        <span class="badge progress">
                            Pending Aproval
                        </span>
                        @endif
                        @if($customer_details->company->status ==
                        config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT') )
                        <span class="badge cancel">
                            Re-submit Request
                        </span>
                        @endif
                    </div>
                    @endif
                </div>

                @if(isset($customer_details->company))
                <div class="flex">
                    <div class="w-2/12">
                        <p>
                            <span class="uppercase text-gray-400 text-xs block">id</span>
                            <span class="primary-color primary-font-medium block mt-2">{{
                                str_pad($customer_details->company->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </p>
                    </div>

                    <div class="w-8/12">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">company name</span>
                                <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                    $customer_details->company->name }}</span>
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">business type</span>
                                <span class="primary-color primary-font-medium block mt-2 view-company-mode">
                                    {{isset($customer_details->company->industry->name) ? $customer_details->company->industry->name : '-'}}
                                </span>
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs flex-inline items-center">corporate email
                                </span>
                                <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                    $customer_details->company->email }}</span>
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">corporate contact</span>
                                <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                    $customer_details->company->contact_no }}</span>
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">country</span>
                                <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                    $customer_details->company->country }}</span>
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">city</span>
                                <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                    $customer_details->company->city }}</span>
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">website</span>
                                <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                    $customer_details->company->website }}</span>
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">about</span>
                                <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                    $customer_details->company->description }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="flex justify-between items-center w-full  pb-1 mb-4 ">
                    <p class="">No Company Information</p>
                </div>
                @endif

            </div>

            <div class="document-section mt-14">
                <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
                    <p class="text-sm primary-font-medium primary-color uppercase">documents</p>
                </div>

                {{--
                <div class="detail-body">
                    <div class="detail-box relative items-center">
                        <div class="w-7/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Document Name</span>
                                    <span class="value">Shipping License</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-3/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Uploaded Date</span>
                                    <span class="value">26 Sept 2023</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-2/12">
                            <div class="flex justify-end">
                                <a href="#" class="default-button-v2 small-button outline-button">
                                    <span>view</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="detail-box relative items-center">
                        <div class="w-7/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Document Name</span>
                                    <span class="value">Shipping License</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-3/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Uploaded Date</span>
                                    <span class="value">26 Sept 2023</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-2/12">
                            <div class="flex justify-end">
                                <a href="#" class="default-button-v2 small-button outline-button">
                                    <span>view</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div> --}}


                <div class="detail-body">
                    @if(isset($customer_details->company) && isset($customer_details->company->documents) &&
                    count($customer_details->company->documents) > 0 )
                    @foreach ( $customer_details->company->documents as $option)
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

                        {{-- <div class="w-4/12">
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
                        </div> --}}

                        <div class="w-3/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Uploaded Date</span>
                                    <span class="value">{{$option->created_at}}</span>
                                </div>
                            </div>
                        </div>


                        <div class="w-2/12">
                            <div class="flex justify-end">


                                <a href="{{ asset('storage/'.$option->path)}}"
                                    class="default-button-v2 small-button outline-button" target="_blank">
                                    <span>view</span></a>
                            </div>
                        </div>


                    </div>
                    @endforeach
                    @else
                    <div class="flex justify-between items-center w-full  pb-1 mb-4 ">
                        <p class="">No Documents </p>
                    </div>
                    @endif
                </div>

            </div>

            <div class="company-assign-section mt-14">
                <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
                    <p class="text-sm primary-font-medium primary-color uppercase">Assign Companies</p>
                </div>
                @if(isset($companies) && count($companies) > 0)

                <?php 
                        $assinged_companies = $customer_details->assigned_companies;
                    ?>

                <form method="POST" action="{{ route('superadmin.assign.companies') }}">
                    <input type="hidden" name="customerID" value="{{$customer_details->id}}" />
                    @csrf
                    @foreach ($companies as $company)
                    <div>
                        <input type="checkbox" id="{{ $company->id }}" name="companies[]" value="{{ $company->id }}" {{
                            $assinged_companies->contains('id', $company->id) ? 'checked' : '' }}
                        >
                        <label for="{{ $company->id }}">{{ $company->name }}</label>
                    </div>
                    @endforeach
                    <button type="submit">Save</button>
                </form>
                @else
                <div class="flex justify-between items-center w-full  pb-1 mb-4 ">
                    <p class="">No Companies found </p>
                </div>
                @endif
            </div>



        </div>

        @endif
    </div>
</section>

@endsection