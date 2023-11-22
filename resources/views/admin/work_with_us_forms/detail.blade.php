@extends('layouts.admin')

@section('content')
<?php
$selected_industry = explode(',', $work_with_us_form_details->industry);

?>
<section class="shadow-box small-box mt-8">
    <div class="dashboard-detail-box">

        <header>
            <h2 class="title">
                Work With Us Detail
            </h2>
            <a href="{{route('superadmin.work-with-us-forms.index')}}" class="default-button-v2 outline-button">
                <span>Back</span>
            </a>
        </header>

        @if(isset($work_with_us_form_details))
        <div class="profile-section mt-14">

            <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
                <p class="text-sm primary-font-medium primary-color uppercase">information</p>
            </div>


            <div class="flex md:w-6/12">
                <div class="grid gap-6">
                    <div class="form-field">
                        <span class="form-label">Full name</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $work_with_us_form_details->first_name }} {{$work_with_us_form_details->last_name}}</span>
                    </div>

                    <div class="form-field">
                        <span class="form-label">Email</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $work_with_us_form_details->email }}</span>
                    </div>

                    <div class="form-field">
                        <span class="form-label">Phone number</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $work_with_us_form_details->phone_number }}</span>
                    </div>

                    <div class="form-field">
                        <span class="form-label">Company</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $work_with_us_form_details->company_name }}</span>
                    </div>

                    <div>
                        <form method="POST" class="default-form"
                        action="{{ route('superadmin.work-with-us-forms.update_status', ['id' => $work_with_us_form_details->id]) }}">

                            <div class="">
                                <span class="form-label">Industry</span>

                                <select name="industry[]" multiple id="industry" required
                                    class="mt-2 block select-multiple">
                                    @if(isset($industries) && count($industries) > 0)
                                    @foreach ($industries as $option)
                                    <option {{ in_array($option, $selected_industry) ? 'selected' : '' }} value="{{ $option}}">{{
                                        $option}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            @csrf
                            @method('PATCH')

                            <div class="form-field mt-6">
                                <span class="form-label">Status</span>
                                <select name="status" id="status" class="form-input w-full">
                                    <option value="{{config('constants.WORK_WITH_US_FORM_STATUS_ACCEPTED')}}" {{
                                        $work_with_us_form_details->status ===
                                        config('constants.WORK_WITH_US_FORM_STATUS_ACCEPTED') ? 'selected' : '' }}>Accept
                                    </option>
                                    <option value="{{config('constants.WORK_WITH_US_FORM_STATUS_REJECTED')}}" {{
                                        $work_with_us_form_details->status ===
                                        config('constants.WORK_WITH_US_FORM_STATUS_REJECTED') ? 'selected' : '' }}>Reject
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="default-button-v2 mt-10">
                                <span>Update</span>
                            </button>
                        </form>
                    </div>


                </div>
            </div>
        </div>



        @endif
    </div>
</section>

@endsection