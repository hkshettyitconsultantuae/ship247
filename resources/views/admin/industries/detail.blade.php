@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <h2 class="title">
                Company Details
            </h2>

            <div>
                <a href="{{route('superadmin.company.index')}}" class="default-button-v2">
                    <span>Back</span>
                </a>
            </div>
        </header>

        @if(isset($company_details))

        <section class="company-section mt-14">

            <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4">
                <p class="text-sm primary-font-medium primary-color uppercase">company information</p>

                <div>
                    @if($company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_APPROVED') )
                    <span class="badge completed">
                        Verified
                    </span>
                    @endif
                    @if($company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_PENDING') )
                    <span class="badge progress">
                        Pending Aproval
                    </span>
                    @endif
                    @if($company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT') )
                    <span class="badge cancel">
                        Re-submit Request
                    </span>
                    @endif
                </div>
            </div>

            <div class="flex">
                <div class="w-2/12">
                    <p>
                        <span class="uppercase text-gray-400 text-xs block">id</span>
                        <span class="primary-color primary-font-medium block mt-2">{{ str_pad($company_details->id, 5,
                            '0', STR_PAD_LEFT) }}</span>
                    </p>
                </div>

                <div class="w-8/12">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Name</span>
                            <span class="primary-color primary-font-medium block mt-2">
                                {{$company_details->name}}
                            </span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Type</span>
                            <span class="primary-color primary-font-medium block mt-2">
                                {{isset($company_details->industry->name) ? $company_details->industry->name : -}}
                            </span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Email</span>
                            <span class="primary-color primary-font-medium block mt-2">
                                {{$company_details->email}}
                            </span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Contact No.</span>
                            <span class="primary-color primary-font-medium block mt-2">
                                {{$company_details->contact_no}}
                            </span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Country</span>
                            <span class="primary-color primary-font-medium block mt-2">
                                {{$company_details->country}}
                            </span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">city</span>
                            <span class="primary-color primary-font-medium block mt-2">
                                {{$company_details->city}}
                            </span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Website</span>
                            <span class="primary-color primary-font-medium block mt-2">
                                {{$company_details->website}}
                            </span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">About</span>
                            <span class="primary-color primary-font-medium block mt-2">
                                {{$company_details->description}}
                            </span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Document Type</span>
                            <span class="primary-color primary-font-medium block mt-2">
                                @if(isset($company_details->documents) && count($company_details->documents) > 0)
                                @foreach ($company_details->documents as $attachment)
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
                                @if(isset($company_details->documents) && count($company_details->documents) > 0)
                                @foreach ($company_details->documents as $attachment)
                                <a href="{{ asset('storage/'.$attachment->path)}}" target="_blank">{{ $attachment->name
                                    }}</a>
                                @endforeach
                                @endif
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        @endif

        @if(isset($users) && count($users) > 0)

        <section class="profile-section mt-14">
            @foreach ( $users as $user )
            <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4">
                <p class="text-sm primary-font-medium primary-color uppercase">user information</p>
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
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">last name</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->last_name }}</span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs flex-inline items-center">email</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->email }}</span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">phone number</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->phone_number }}</span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">country</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->country }}</span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">city</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->city }}</span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">department</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->department }}</span>
                        </div>

                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">job title</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->job_title }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </section>
        @endif

        <section class="mt-20">
            @if(isset($company_details))

            @if($company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_PENDING') ||
            $company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT'))
            <form method="POST" action="{{route('superadmin.companyStatus.update',$company_details->id )}}"
                class="default-form">
                @csrf

                <button type="submit" name="status" class="default-button-v2"
                    value="{{config('constants.COMPANY_REGISTRATION_STATUS_APPROVED')}}">
                    <span>Approve</span>
                </button>
                <button type="button" id="rejectBtn" class="default-button-v2 outline-button ml-4">
                    <span>Resubmit</span>
                </button>

                <div id="rejectFields" style="display: none;" class="text-left mt-10">
                    <div class="form-field">
                        <label for="message" class="form-label">Message:</label>
                        <textarea name="message" id="message" class="form-input resize-none w-5/12 h-32"
                            required> </textarea>
                    </div>
                    <div class="form-field">
                        <button type="submit" name="status" class="default-button-v2 small-button"
                            value="{{config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT')}}">
                            <span>Submit</span>
                        </button>
                    </div>
                </div>
            </form>
            @endif
            @endif
        </section>


        {{-- <section class="status-section mt-14">
            <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4">
                <p class="text-sm primary-font-medium primary-color uppercase">Status History</p>
            </div>
        </section>

        @if(isset($company_details))


        <table class="shipping-details">
            <thead>
                <th>
                    <span class="head">Status</span>
                </th>

                <th>
                    <span class="head">DateTime</span>
                </th>
            </thead>

            <tbody>

                @if(isset($company_details->history) && count($company_details->history) > 0)
                @foreach ($company_details->history as $history )


                <tr>
                    <td>
                        @if(config('constants.COMPANY_REGISTRATION_STATUS_APPROVED') == $history->status )
                        <span>Verified</span>
                        @elseif(config('constants.COMPANY_REGISTRATION_STATUS_PENDING') == $history->status )
                        <span>Pending</span>
                        @elseif(config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT') == $history->status )
                        <span>Resubmit <strong>Message: </strong> {{$history->message}} </span>
                        @endif

                    </td>

                    <td>
                        <span>{{ $history->created_at }}</span>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td>
                        <span>No history</span>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>


        @endif

        {{-- <footer>
            <p class="number">Showing <strong>1 - 10</strong></p>
            <ul class="pagination">
                <li class="active">
                    1
                </li>
                <li>
                    2
                </li>
                <li>
                    3
                </li>
            </ul>
            <p class="total">Total <strong>200</strong></p>
        </footer> --}}
    </div>
</section>


<script>
    const rejectBtn = document.getElementById('rejectBtn');
    const rejectFields = document.getElementById('rejectFields');

    rejectBtn.addEventListener('click', function() {
        rejectFields.style.display = 'block';
    });
</script>

@endsection