@extends('layouts.admin')

@section('content')
<?php

$bookingData = $bookings->toArray();

$inProgressBookingsCount = count(array_filter($bookingData["data"], function ($booking) {
    return $booking['status'] === config('constants.BOOKING_STATUS_IN_PROGRESS') ;
}));

$cancelledBookingsCount = count(array_filter($bookingData["data"], function ($booking) {
    return $booking['status'] ===config('constants.BOOKING_STATUS_CANCELLED');
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
            <div class="w-3/12">
                <h2 class="title">
                    Bookings
                </h2>
            </div>
            <div class="w-6/12">
                <form class="dashboard-searchbar">
                    <input type="text" class="search-bar"
                        placeholder="Search By : BL, SHIPPING LINE, POO, POD, AMOUNT, TRANSPORTATION, STATUS ETC. …." />
                    <button class="submit-btn">
                        <img src="/images/svg/search-icon.svg" alt="">
                    </button>
                </form>
            </div>

            <div class="w-3/12 justify-end flex">
                <a href="/" class="default-button-v2">
                    <span>new booking</span>
                </a>
            </div>
        </header>

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
                        <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="canceled-tab"
                            data-tabs-target="#canceled" type="button" role="tab" aria-controls="canceled"
                            aria-selected="false">Canceled</button>
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
                    <div class="detail-box">
                        <div class="w-2/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Booking ID</span>
                                    <span class="value">{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} </span>
                                </div>

                                {{-- <div>
                                    <span class="head">BL</span>
                                    <span class="value">22317899</span>
                                </div> --}}

                                {{-- <div>
                                    <span class="head">No of Container</span>
                                    <span class="value">{{$booking->no_of_containers}}</span>
                                </div> --}}
                            </div>
                        </div>

                        <div class="w-3/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">from</span>
                                    <span class="value">{{isset($booking->origin->fullname) ? $booking->origin->fullname : ''}}</span>
                                </div>

                                {{-- <div>
                                    <span class="head">Container</span>
                                    <span class="value">{{$booking->container_size}}</span>
                                </div> --}}
                            </div>
                        </div>

                        <div class="w-3/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">to</span>
                                    <span class="value">{{isset($booking->destination->fullname) ? $booking->destination->fullname : ''}}</span>
                                </div>

                                {{-- <div>
                                    <span class="head">product</span>
                                    <span class="value">{{$booking->product}}</span>
                                </div> --}}
                            </div>
                        </div>

                        <div class="w-2/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">amount</span>
                                    <span class="value">{{ '$' . number_format($booking->amount, 2) }}</span>
                                </div>

                                {{-- <div>
                                    <span class="head">CARGO READY</span>
                                    <span class="value">{{ date('d M y', strtotime($booking->departure_date_time))
                                        }}</span>
                                </div> --}}
                            </div>
                        </div>

                        <div class="w-2/12">
                            {{-- <div class="flex flex-col gap-4"> --}}
                                <div class="flex justify-center items-center h-full">
                                    <div>
                                        @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
                                        <span class="badge completed">
                                            Completed
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                                        <span class="badge progress">
                                            In-Progress
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
                                        <span class="badge cancel">
                                            Cancelled
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_ON_HOLD'))
                                        <span class="badge hold">
                                            On-hold
                                        </span>
                                        @endif
                                    </div>
                                    {{-- <div>
                                        <span class="head">Transportation</span>
                                        <span class="value">{{$booking->transportation}}</span>
                                    </div> --}}

                                    {{-- <div>
                                        <span class="head">Shipping line</span>
                                        <span class="value">{{$booking->shipping_line}}</span>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex justify-end items-center h-full">
                                    {{-- <div>
                                        @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
                                        <span class="badge completed">
                                            Completed
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                                        <span class="badge progress">
                                            In-Progress
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
                                        <span class="badge cancel">
                                            Cancelled
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_ON_HOLD'))
                                        <span class="badge hold">
                                            On-hold
                                        </span>
                                        @endif
                                    </div> --}}
                                    <div>
                                        <a href="{{ route('customer.bookings.show', [$booking->id]) }}"
                                            class="default-button small-button red">view details</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endforeach

                        @else

                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-500">No bookings found</p>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="hidden" id="inprogress" role="tabpanel"
                    aria-labelledby="inprogress-tab">
                    <div class="detail-body">
                        @if(isset($bookings) && count($bookings)> 0 && $inProgressBookingsCount > 0)
                        @foreach ($bookings as $booking)
                        @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                        <div class="detail-box">
                            <div class="w-2/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Booking ID</span>
                                        <span class="value">{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} </span>
                                    </div>

                                </div>
                            </div>

                            <div class="w-3/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">from</span>
                                        <span class="value">{{isset($booking->origin->fullname) ? $booking->origin->fullname : ''}}</span>
                                    </div>


                                </div>
                            </div>

                            <div class="w-3/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">to</span>
                                        <span class="value">{{isset($booking->destination->fullname) ? $booking->destination->fullname : ''}}</span>
                                    </div>

                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">amount</span>
                                        <span class="value">{{ '$' . number_format($booking->amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/12">

                                <div class="flex justify-center items-center h-full">
                                    <div>
                                        @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
                                        <span class="badge completed">
                                            Completed
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                                        <span class="badge progress">
                                            In-Progress
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
                                        <span class="badge cancel">
                                            Cancelled
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_ON_HOLD'))
                                        <span class="badge hold">
                                            On-hold
                                        </span>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex justify-end items-center h-full">

                                    <div>
                                        <a href="{{ route('customer.bookings.show', [$booking->id]) }}"
                                            class="default-button small-button red">view details</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endif
                        @endforeach
                        @else
                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-500">No in-progress bookings found</p>
                        </div>
                        @endif

                    </div>
                </div>
                <div class="hidden" id="completed" role="tabpanel"
                    aria-labelledby="completed-tab">
                    <div class="detail-body">
                        @if(isset($bookings) && count($bookings)> 0 && $completedBookingsCount > 0)
                        @foreach ($bookings as $booking)
                        @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
                        <div class="detail-box">
                            <div class="w-2/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Booking ID</span>
                                        <span class="value">{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} </span>
                                    </div>

                                </div>
                            </div>

                            <div class="w-3/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">from</span>
                                        <span class="value">{{isset($booking->origin->fullname) ? $booking->origin->fullname : ''}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-3/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">to</span>
                                        <span class="value">{{isset($booking->destination->fullname) ? $booking->destination->fullname : ''}}</span>
                                    </div>

                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">amount</span>
                                        <span class="value">{{ '$' . number_format($booking->amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/12">

                                <div class="flex justify-center items-center h-full">
                                    <div>
                                        @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
                                        <span class="badge completed">
                                            Completed
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                                        <span class="badge progress">
                                            In-Progress
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
                                        <span class="badge cancel">
                                            Cancelled
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_ON_HOLD'))
                                        <span class="badge hold">
                                            On-hold
                                        </span>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex justify-end items-center h-full">

                                    <div>
                                        <a href="{{ route('customer.bookings.show', [$booking->id]) }}"
                                            class="default-button small-button red">view details</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endif
                        @endforeach
                        @else
                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-500">No completed bookings found</p>
                        </div>
                        @endif

                    </div>
                </div>
                <div class="hidden" id="canceled" role="tabpanel"
                    aria-labelledby="canceled-tab">
                    <div class="detail-body">
                        @if(isset($bookings) && count($bookings)> 0 && $cancelledBookingsCount > 0)
                        @foreach ($bookings as $booking)
                        @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
                        <div class="detail-box">
                            <div class="w-2/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Booking ID</span>
                                        <span class="value">{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} </span>
                                    </div>

                                </div>
                            </div>

                            <div class="w-3/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">from</span>
                                        <span class="value">{{isset($booking->origin->fullname) ? $booking->origin->fullname : ''}}</span>
                                    </div>


                                </div>
                            </div>

                            <div class="w-3/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">to</span>
                                        <span class="value">{{isset($booking->destination->fullname) ? $booking->destination->fullname : ''}}</span>
                                    </div>

                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">amount</span>
                                        <span class="value">{{ '$' . number_format($booking->amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/12">

                                <div class="flex justify-center items-center h-full">
                                    <div>
                                        @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
                                        <span class="badge completed">
                                            Completed
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                                        <span class="badge progress">
                                            In-Progress
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
                                        <span class="badge cancel">
                                            Cancelled
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_ON_HOLD'))
                                        <span class="badge hold">
                                            On-hold
                                        </span>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex justify-end items-center h-full">

                                    <div>
                                        <a href="{{ route('customer.bookings.show', [$booking->id]) }}"
                                            class="default-button small-button red">view details</a>
                                    </div>
                                </div>
                            </div>

                        </div>
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
                        @if($booking->status == config('constants.BOOKING_STATUS_ON_HOLD'))
                        <div class="detail-box">
                            <div class="w-2/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Booking ID</span>
                                        <span class="value">{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} </span>
                                    </div>

                                </div>
                            </div>

                            <div class="w-3/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">from</span>
                                        <span class="value">{{isset($booking->origin->fullname) ? $booking->origin->fullname : ''}}</span>
                                    </div>


                                </div>
                            </div>

                            <div class="w-3/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">to</span>
                                        <span class="value">{{isset($booking->destination->fullname) ? $booking->destination->fullname : ''}}</span>
                                    </div>

                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">amount</span>
                                        <span class="value">{{ '$' . number_format($booking->amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/12">

                                <div class="flex justify-center items-center h-full">
                                    <div>
                                        @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
                                        <span class="badge completed">
                                            Completed
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                                        <span class="badge progress">
                                            In-Progress
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
                                        <span class="badge cancel">
                                            Cancelled
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_ON_HOLD'))
                                        <span class="badge hold">
                                            On-hold
                                        </span>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex justify-end items-center h-full">

                                    <div>
                                        <a href="{{ route('customer.bookings.show', [$booking->id]) }}"
                                            class="default-button small-button red">view details</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endif
                        @endforeach
                        @else
                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-500">No onhold bookings found</p>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

            <footer>
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
            </footer>
        </div>
</section>
@endsection
