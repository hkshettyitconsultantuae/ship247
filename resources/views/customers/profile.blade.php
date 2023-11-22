@extends('layouts.admin')

@section('content')
<?php 
// dd(config('constants.COMPANY_REGISTRATION_STATUS_APPROVED') == $user->company->status);

?>
<section class="shadow-box small-box mt-8">
    <div class="dashboard-detail-box">

        <header>
            <div class="w-3/12">
                <h2 class="title">
                    {{ $user->first_name }} {{ $user->last_name }}
                </h2>
            </div>

            <div class="w-3/12">
                <p class="primary-color primary-font-medium text-right">
                    Account Type: <span class="primary-font-regular">Individual</span>
                </p>
            </div>
        </header>

        @if(isset($user))
        <div class="profile-section mt-14">
            <form id="user-form" method="POST" action="{{ route('customer.update.profile', $user->id) }}"
                class="default-form">
                @csrf

                <input type="hidden" name="userID" value="{{ $user->id }}" />

                <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
                    <p class="text-sm primary-font-medium primary-color uppercase">personal information</p>

                    <button type="button" onclick="personalEditMode()"
                        class="view-personal-mode text-purple-800 text-xs primary-font-medium uppercase">
                        <span class="">Edit</span>
                    </button>

                    <div class="edit-personal-mode hidden">
                        <button type="submit" class="badge success">Save</button>
                        <button type="button" onclick="personalCancelMode()" class="badge cancel">Cancel</button>
                    </div>
                </div>


                <div class="flex">
                    <div class="w-2/12">
                        <p>
                            <span class="uppercase text-gray-400 text-xs block">id</span>
                            <span class="primary-color primary-font-medium block mt-2">{{ $user->id }}</span>
                        </p>
                    </div>

                    <div class="w-8/12">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">first name</span>
                                <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                    $user->first_name }}</span>
                                <input required type="text" id="first_name" name="first_name"
                                    value="{{ $user->first_name }}"
                                    class="form-input small-input mt-2 w-9/12 block edit-personal-mode hidden">
                                @error('first_name')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">last name</span>
                                <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                    $user->last_name }}</span>
                                <input required type="text" id="last_name" name="last_name"
                                    value="{{ $user->last_name }}"
                                    class="form-input small-input mt-2 w-9/12 block edit-personal-mode hidden">
                                @error('last_name')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs flex-inline items-center">email
                                    <span class="badge small-badge success ml-1 view-personal-mode">approved</span>
                                </span>
                                <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                    $user->email }}</span>
                                <input readonly required type="text" id="email" name="email" value="{{ $user->email }}"
                                    class="form-input small-input mt-2 w-9/12 block edit-personal-mode hidden">
                                @error('email')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">phone number</span>
                                <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                    $user->phone_number }}</span>
                                <input required type="text" id="phone_number" name="phone_number"
                                    value="{{ $user->phone_number }}"
                                    class="form-input small-input mt-2 w-9/12 block edit-personal-mode hidden">
                                @error('phone_number')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">country</span>
                                <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                    $user->country }}</span>
                                <input required type="text" id="country" name="country" value="{{ $user->country }}"
                                    class="form-input small-input mt-2 w-9/12 block edit-personal-mode hidden">
                                @error('country')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">city</span>

                                @if($user->city == null)
                                <button type="button" onclick="personalEditMode()"
                                    class="view-personal-mode text-red-600 primary-font-medium uppercase mt-2">
                                    <span class="">Add</span>
                                </button>
                                @else
                                <span class="primary-color primary-font-medium block mt-2 view-personal-mode">
                                    {{ $user->city }}
                                </span>
                                @endif
                                <input type="text" id="city" name="city" value="{{ $user->city }}"
                                    class="form-input small-input mt-2 w-9/12 block edit-personal-mode hidden">
                                @error('city')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">department</span>
                                @if($user->department == null)
                                <button type="button" onclick="personalEditMode()"
                                    class="view-personal-mode text-red-600 primary-font-medium uppercase mt-2">
                                    <span class="">Add</span>
                                </button>
                                @else
                                <span class="primary-color primary-font-medium block mt-2 view-personal-mode">
                                    {{ $user->department}}
                                </span>
                                @endif
                                <input type="text" id="department" name="department" value="{{ $user->department }}"
                                    class="form-input small-input mt-2 w-9/12 block edit-personal-mode hidden">
                                @error('department')
                                <span class="error-field">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">job title</span>

                                @if($user->job_title == null)
                                <button type="button" onclick="personalEditMode()"
                                    class="view-personal-mode text-red-600 primary-font-medium uppercase mt-2">
                                    <span class="">Add</span>
                                </button>
                                @else
                                <span class="primary-color primary-font-medium block mt-2 view-personal-mode">
                                    {{ $user->job_title}}
                                </span>
                                @endif
                                <input type="text" id="job_title" name="job_title" value="{{ $user->job_title }}"
                                    class="form-input small-input mt-2 w-9/12 block edit-personal-mode hidden">
                                @error('job_title')
                                <span class="error-field">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="">
            <div class="company-section mt-14">
                <form id="user-form" method="POST" action="{{ route('superadmin.update.profile', $user->id) }}"
                    class="default-form">
                    @csrf
                    <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
                        <p class="text-sm primary-font-medium primary-color uppercase">company information</p>

                        {{-- <button type="button" onclick="companyEditMode()"
                            class="view-company-mode text-purple-800 text-xs primary-font-medium uppercase">
                            <span class="">Edit</span>
                        </button>

                        <div class="edit-company-mode hidden">
                            <button type="submit" class="badge success">Save</button>
                            <button type="button" onclick="companyCancelMode()" class="badge cancel">Cancel</button>
                        </div> --}}
                    </div>

                    <div class="text-center">
                        @if(isset($user->company))
                        @if(config('constants.COMPANY_REGISTRATION_STATUS_PENDING') == $user->company->status )
                        <a href="{{route('company.index')}}" class="default-button-v2">
                            <span>Pending for approval</span>
                        </a>
                        @elseif(config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT') == $user->company->status )
                        <a href="{{route('company.index')}}" class="default-button-v2">
                            <span>Resubmit request</span>
                        </a>
                        @endif
                        @else
                        <a href="{{route('company.index')}}" class="default-button-v2">
                            <span>Work with us</span>
                        </a>
                        @endif


                    </div>

                    @if(isset($user->company) && config('constants.COMPANY_REGISTRATION_STATUS_APPROVED') ==
                    $user->company->status )
                    <div class="flex">
                        <div class="w-2/12">
                            <p>
                                <span class="uppercase text-gray-400 text-xs block">id</span>
                                <span class="primary-color primary-font-medium block mt-2">{{
                                    $user->company->id}}</span>
                            </p>
                        </div>

                        <div class="w-8/12">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">company name</span>
                                    <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                        $user->company->name }}</span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">business type</span>
                                    <span class="primary-color primary-font-medium block mt-2 view-company-mode">

                                        @if ($user->company->business_type &&
                                        config('constants.COMPANY_BUSINESS_TYPE') &&
                                        count(config('constants.COMPANY_BUSINESS_TYPE')) > 0 )

                                        @foreach (config('constants.COMPANY_BUSINESS_TYPE') as $businessType)

                                        @if ($businessType->value === $user->company->business_type)
                                        {{ $businessType->label }}
                                        @endif
                                        @endforeach
                                        @endif


                                    </span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs flex-inline items-center">corporate
                                        email </span>
                                    <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                        $user->company->email }}</span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">corporate contact</span>
                                    <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                        $user->company->contact_no }}</span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">country</span>
                                    <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                        $user->company->country }}</span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">city</span>
                                    <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                        $user->company->city }}</span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">website</span>
                                    <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                        $user->company->website }}</span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">about</span>
                                    <span class="primary-color primary-font-medium block mt-2 view-company-mode">{{
                                        $user->company->description }}</span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Document Type</span>
                                    <span class="primary-color primary-font-medium block mt-2">
                                        @if(isset($user->company->documents) && count($user->company->documents) > 0)
                                        @foreach ($user->company->documents as $attachment)
                                        <?php $result = array_filter(config('constants.COMPANY_DOCUMENTS'), function($item) use ($attachment) {
                                            return $item->value == $attachment->type;
                                        });
                                        $matchingObject = reset($result);
                                        ?>
                                        @if (!empty($result))
                                        {{ $matchingObject->label }}
                                        @endif
                                        @endforeach
                                        @endif
                                    </span>
                                </div>
        
                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Document Name</span>
                                    <span class="primary-color primary-font-medium block mt-2">
                                        @if(isset($user->company->documents) && count($user->company->documents) > 0)
                                        @foreach ($user->company->documents as $attachment)
                                        <a href="{{ asset('storage/'.$attachment->path)}}" target="_blank">{{ $attachment->name
                                            }}</a>
                                        @endforeach
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>

            {{-- <div class="document-section mt-14">
                <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
                    <p class="text-sm primary-font-medium primary-color uppercase">documents</p>
                    <button type="button" data-modal-target="uploadDocument" data-modal-toggle="uploadDocument"
                        class="default-button-v2 small-button outline-button">
                        <span class="text-black">upload</span>
                    </button>
                </div>


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
                                    <span>Delete</span>
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
                                    <span>Delete</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


        </div>

        <div class="security-section mt-14">

            <div class="card-body">
                @if (session('status'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        {{ session('status') }}
                    </div>
                @endif


                <form id="user-form" method="POST" action="{{ route('customer.password.update', $user->id) }}"
                    class="default-form">
                    @csrf

                    <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
                        <p class="text-sm primary-font-medium primary-color uppercase">security</p>

                        <button type="button" onclick="securityEditMode()"
                            class="view-security-mode text-purple-800 text-xs primary-font-medium uppercase">
                            <span class="">change password</span>
                        </button>

                        <div class="edit-security-mode hidden">
                            <button type="submit" class="badge success">Save</button>
                            <button type="button" onclick="securityCancelMode()" class="badge cancel">Cancel</button>
                        </div>
                    </div>


                    <div class="flex">

                        <div class="w-8/12">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">password</span>
                                    <span
                                        class="primary-color primary-font-medium block mt-2 view-security-mode">******</span>
                                    <input required type="password" id="password" name="password" value=""
                                        class="form-input small-input mt-2 w-9/12 block edit-security-mode hidden">
                                    @error('password')
                                    <span class="error-field">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-field edit-security-mode hidden">
                                    <span class="uppercase text-gray-400 text-xs block">confirm password</span>
                                    <input required type="password" id="password_confirmation"
                                        name="password_confirmation" value=""
                                        class="form-input small-input mt-2 w-9/12 block edit-security-mode hidden">
                                    @error('password_confirmation')
                                    <span class="error-field">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>

</section>

@endsection