@extends('layouts.admin')

@section('content')
<?php

$bookingData = $bookings->toArray();

$inProgressBookingsCount = count(array_filter($bookingData["data"], function ($booking) {
    return $booking['status'] === config('constants.BOOKING_STATUS_IN_PROGRESS') ;
}));

$cancelledBookingsCount = count(array_filter($bookingData["data"], function ($booking) {
    return $booking['status'] === config('constants.BOOKING_STATUS_CANCELLED');
}));

$onHoldBookingsCount = count(array_filter($bookingData["data"], function ($booking) {
    return $booking['status'] ===config('constants.BOOKING_STATUS_ON_HOLD');
}));

$completedBookingsCount = count(array_filter($bookingData["data"], function ($booking) {
    return $booking['status'] ===config('constants.BOOKING_STATUS_COMPLETED');
}));
?>
<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="md:w-6/12">
                <h2 class="title">
                    Bookings
                </h2>
            </div>
    
            <div class="md:w-6/12 md:justify-end flex">
                <a href="/" class="default-button-v2">
                    <span>new booking</span>
                </a>
            </div>
        </header>
        <section class="search-result mt-8 mb-12">
               
            <form class="default-form" action="{{ route('superadmin.bookings.index') }}" method="GET">

                <div class="flex lg:items-end items-start lg:flex-row flex-col lg:gap-6 gap-4">
                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="origin_id" class="form-label-small">Origin</label>
                            @include('admin.partials._location-select2',
                                [
                                    'name' => 'origin_id',
                                    'selected_option_value' => $origin->id ?? null,
                                    'selected_option_text' => $origin->fullname ?? null,
                                ]
                            )
                        </div>
                    </div>
                    
                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="destination_id" class="form-label-small">Destination</label>
                            @include('admin.partials._location-select2',
                                [
                                    'name' => 'destination_id',
                                    'selected_option_value' => $destination->id ?? null,
                                    'selected_option_text' => $destination->fullname ?? null,
                                ]
                            )
                        </div>
                    </div>
                    
                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="company_id" class="form-label-small">Company</label>
                            <select id="company_id" name="company_id"
                                    class="form-input small-input w-full">
                                <option value="">Select Company</option>
                                @if(isset($companies) && count($companies) >0  )
                                @foreach($companies as $company_id => $company_name)
                                    <option value="{{ $company_id }}"
                                            @if( isset($company) && $company->id == $company_id) selected @endif
                                    >{{$company_name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    
                    <div class="lg:w-3/12 w-full">
                        <button type="submit" class="default-button-v2 outline-button">
                            <span>Search</span>
                        </button>
                    </div>
                    
                </div>

            </form>
        </section>

        <div class="tabbing mt-8">
            <div class="mb-8 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                    data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 pb-2 rounded-t-lg" id="all-tab" data-tabs-target="#all"
                            type="button" role="tab" aria-controls="all" aria-selected="false">All</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="inprogress-tab"
                            data-tabs-target="#inprogress" type="button" role="tab" aria-controls="inprogress"
                            aria-selected="false">in-progress</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="completed-tab"
                            data-tabs-target="#completed" type="button" role="tab" aria-controls="completed"
                            aria-selected="false">Completed</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="cancelled-tab"
                            data-tabs-target="#cancelled" type="button" role="tab" aria-controls="cancelled"
                            aria-selected="false">Cancelled</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="onhold-tab"
                            data-tabs-target="#onhold" type="button" role="tab" aria-controls="onhold"
                            aria-selected="false">on-hold</button>
                    </li>
                </ul>
            </div>
        </div>

        <div id="myTabContent">
            <div class="" id="all" role="tabpanel" aria-labelledby="all-tab">
                <div class="detail-body">
                    @if(isset($bookings) && count($bookings)> 0)
                        @foreach ($bookings as $booking)
                            @include('admin.partials._booking-detail-box', ['booking' => $booking])
                        @endforeach
                    @else
                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-500">No bookings found</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="hidden" id="inprogress" role="tabpanel" aria-labelledby="inprogress-tab">
                <div class="detail-body">
                    @if(isset($bookings) && count($bookings)> 0 && $inProgressBookingsCount > 0)
                        @foreach ($bookings as $booking)
                            @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS') )
                                @include('admin.partials._booking-detail-box', ['booking' => $booking])
                            @endif
                        @endforeach
                    @else
                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-500">No in-progress bookings found</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="hidden" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                <div class="detail-body">
                    @if(isset($bookings) && count($bookings)> 0 && $completedBookingsCount > 0)
                        @foreach ($bookings as $booking)
                            @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
                                @include('admin.partials._booking-detail-box', ['booking' => $booking])
                            @endif
                        @endforeach
                    @else
                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-500">No bookings found</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="hidden" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                <div class="detail-body">
                    @if(isset($bookings) && count($bookings)> 0 && $cancelledBookingsCount > 0)
                        @foreach ($bookings as $booking)
                            @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED') )
                                @include('admin.partials._booking-detail-box', ['booking' => $booking])
                            @endif
                        @endforeach
                    @else
                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-500">No cancelled bookings found</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="hidden" id="onhold" role="tabpanel" aria-labelledby="onhold-tab">
                <div class="detail-body">
                    @if(isset($bookings) && count($bookings)> 0 && $onHoldBookingsCount > 0)
                        @foreach ($bookings as $booking)
                            @if($booking->status == config('constants.BOOKING_STATUS_ON_HOLD') )
                                @include('admin.partials._booking-detail-box', ['booking' => $booking])
                            @endif
                        @endforeach
                    @else
                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-500">No cancelled bookings found</p>
                        </div>
                    @endif
                </div>
            </div>

            <footer>
                <p class="number">Showing <strong>{{ $bookings->firstItem() }} - {{ $bookings->lastItem() }} </strong></p>
                {{ $bookings->links() }}
            </footer>
        </div>
    </div>
</section>
@endsection
