@extends('layouts.admin')

@section('content')
<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <h2 class="title">
                Bookings Details
            </h2>
            <div>
                <a href="{{route('superadmin.bookings.index')}}" class="default-button-v2">
                    <span>Back</span>
                </a>
            </div>
        </header>

        @if(isset($booking))
        <div class="detail-body">
            <div class="detail-box relative">
                <div class="absolute left-4 -top-4">
                    @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED'))
                    <span class="badge completed small-badge">
                        Completed
                    </span>
                    @endif
                    @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                    <span class="badge progress small-badge">
                        In-Progress
                    </span>
                    @endif
                    @if($booking->status ==config('constants.BOOKING_STATUS_CANCELLED'))
                    <span class="badge cancel small-badge">
                        Cancelled
                    </span>
                    @endif
                    @if($booking->status == config('constants.BOOKING_STATUS_ON_HOLD'))
                    <span class="badge hold small-badge">
                        On-hold
                    </span>
                    @endif
                </div>

                <div class="xl:w-2/12 lg:mb-0 mb-4">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Booking ID</span>
                            <span class="value">{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        <div>
                            <span class="head">No of Container</span>
                            <span class="value">{{$booking->no_of_containers}}</span>
                        </div>

                        <div>
                            <span class="head">Shipping Number</span>
                            <span class="value">{{isset($booking->shipping_number) ? $booking->shipping_number :
                                '-'}}</span>
                        </div>

                    </div>
                </div>

                <div class="xl:w-3/12 lg:mb-0 mb-4">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">from</span>
                            <span class="value">{{isset($booking->origin->fullname) ? $booking->origin->fullname :
                                '-'}}</span>
                        </div>

                        <div>
                            <span class="head">Container</span>
                            <span class="value">{{$booking->container_size}}</span>
                        </div>

                        <div>
                            <span class="head">Receipt Number</span>
                            <span class="value">{{isset($booking->receipt_number) ? $booking->receipt_number :
                                '-'}}</span>
                        </div>
                    </div>
                </div>

                <div class="xl:w-3/12 lg:mb-0 mb-4">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">to</span>
                            <span class="value">{{isset($booking->destination->fullname) ?
                                $booking->destination->fullname : ''}}</span>
                        </div>

                        {{-- <div>
                            <span class="head">product</span>
                            <span class="value">{{$booking->product}}</span>
                        </div> --}}

                        <div>
                            <span class="head">Transportation</span>
                            <span class="value">{{$booking->transportation}}</span>
                        </div>
                    </div>
                </div>

                <div class="xl:w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">amount</span>
                            <span class="value">{{ '$' . number_format($booking->amount, 2) }}</span>
                        </div>

                        <div>
                            <span class="head">CARGO READY</span>
                            <span class="value">{{ date('d M y', strtotime($booking->departure_date_time))
                                }}</span>
                        </div>

                        <div>
                            <span class="head">Shipping line</span>
                            <span class="value">{{isset($booking->company->name) ? $booking->company->name :
                                '-'}}</span>
                        </div>
                    </div>
                </div>

                {{-- <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Transportation</span>
                            <span class="value">{{$booking->transportation}}</span>
                        </div>

                        <div>
                            <span class="head">Shipping line</span>
                            <span class="value">{{isset($booking->company->name) ? $booking->company->name :
                                '-'}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Shipping Number</span>
                            <span class="value">{{isset($booking->shipping_number) ? $booking->shipping_number :
                                '-'}}</span>
                        </div>

                        <div>
                            <span class="head">Receipt Number</span>
                            <span class="value">{{isset($booking->receipt_number) ? $booking->receipt_number :
                                '-'}}</span>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        @if(isset($booking->addons) && count($booking->addons) > 0)
        <h2 class="title mt-8">
            Bookings Addons Details
        </h2>
        <div class="detail-body">
            @foreach ($booking->addons as $addon)
            <div class="detail-box relative">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">{{$addon->name}}</span>
                        @if($addon->type === 'toggle')
                        @if(is_numeric($addon->value))
                        <span class="value">{{ '$' . number_format($addon->value, 2) }}</span>
                        @else
                        <span class="value">{{$addon->value}}</span>
                        @endif
                        @elseif($addon->type === 'counter')
                        @if(floatval($addon->step) > 0)
                        <span class="value">{{ '$' . number_format($addon->value * floatval($addon->step) , 2) }}</span>
                        @else
                        <span class="value">{{ '$' . number_format($addon->value, 2) }}</span>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <h2 class="title mt-8">
            Bookings Price Breakdown 
        </h2>

        <div class="detail-body">

            <div class="detail-box relative">
                @if ($booking->is_checked_pickup_charges  == 'Y')
                <div class=" lg:mb-0 mb-4">
                    <div>
                        <span class="head">Pickup Charges</span>
                        <span class="value">{{ '$' . number_format($booking->pickup_charges, 2) }}</span>

                    </div>
                </div>
                @endif
               
               
                @if ($booking->is_checked_origin_charges == 'Y')
                <div class=" lg:mb-0 mb-4">
                    <div>
                        <span class="head">Origin Charges</span>
                        <span class="value">{{ '$' . number_format($booking->origin_charges, 2) }}</span>

                    </div>
                </div>
                @endif
               
               
                @if ($booking->is_checked_basic_ocean_freight  == 'Y')
                <div class=" lg:mb-0 mb-4">
                    <div>
                        <span class="head">Basic Ocean Freight Charges</span>
                        <span class="value">{{ '$' . number_format($booking->basic_ocean_freight , 2) }}</span>

                    </div>
                </div>
                @endif
               
                @if ($booking->is_checked_destination_charges  == 'Y')
                <div class=" lg:mb-0 mb-4">
                    <div>
                        <span class="head">Destination Charges</span>
                        <span class="value">{{ '$' . number_format($booking->destination_charges , 2) }}</span>

                    </div>
                </div>
                @endif
             
                @if ($booking->is_checked_delivery_charges   == 'Y')
                <div class="">
                    <div>
                        <span class="head">Delivery Charges</span>
                        <span class="value">{{ '$' . number_format($booking->delivery_charges  , 2) }}</span>

                    </div>
                </div>
                @endif

            </div>

        </div>

        @endif
    </div>
</section>
@endsection