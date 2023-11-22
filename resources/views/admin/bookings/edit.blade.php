@extends('layouts.admin')

@section('content')
<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <h2 class="title">
                Bookings Details
            </h2>
            <div class="searchbar">

            </div>
            <div>
                <a href="{{route('superadmin.bookings.index')}}" class="default-button-v2">
                    <span>Back</span>
                </a>
            </div>
        </header>

        @if(isset($booking))
        <div class="detail-body">
            <div class="detail-box">
                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Booking ID</span>
                            <span class="value">{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        <div>
                            <span class="head">No of Container</span>
                            <span class="value">{{$booking->no_of_containers}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
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
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">to</span>
                            <span class="value">{{isset($booking->destination->fullname) ?
                                $booking->destination->fullname : ''}}</span>
                        </div>

                        <div>
                            <span class="head">product</span>
                            <span class="value">{{$booking->product}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
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
                    </div>
                </div>

                <div class="w-2/12">
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
                    <div class="flex justify-between flex-col items-end h-full">
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
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Pickup Charges</span>
                        <span class="value">{{ '$' . number_format($booking->pickup_charges, 2) }}</span>

                    </div>
                </div>
                @endif
               
               
                @if ($booking->is_checked_origin_charges == 'Y')
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Origin Charges</span>
                        <span class="value">{{ '$' . number_format($booking->origin_charges, 2) }}</span>

                    </div>
                </div>
                @endif
               
               
                @if ($booking->is_checked_basic_ocean_freight  == 'Y')
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Basic Ocean Freight Charges</span>
                        <span class="value">{{ '$' . number_format($booking->basic_ocean_freight , 2) }}</span>

                    </div>
                </div>
                @endif
               
                @if ($booking->is_checked_destination_charges  == 'Y')
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Destination Charges</span>
                        <span class="value">{{ '$' . number_format($booking->destination_charges , 2) }}</span>

                    </div>
                </div>
                @endif
             
                @if ($booking->is_checked_delivery_charges   == 'Y')
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Delivery Charges</span>
                        <span class="value">{{ '$' . number_format($booking->delivery_charges  , 2) }}</span>

                    </div>
                </div>
                @endif


            </div>

        </div>


        <section class="mt-20">


            <form method="POST" action="{{ route('superadmin.bookingDetails.update', $booking->id) }}" class="default-form">
                @csrf
                <div class="grid grid-cols-1 gap-8 mt-6">
                    <div class="form-field">
                        <label for="shipping_number" class="form-label">Shipping Number</label>
                        <input type="text" id="shipping_number" name="shipping_number" class="form-input small-input mt-2 w-full block" value="{{ $booking->shipping_number }}">
                        @error('shipping_number')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>
            
                    <div class="form-field">
                        <label for="receipt_number" >Receipt Number</label>
                        <input type="text" id="receipt_number" name="receipt_number" class="form-input small-input mt-2 w-full block" value="{{ $booking->receipt_number }}">
                        @error('receipt_number')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>
            
                    <div class="form-field">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" required class="form-input small-input mt-2 w-full block">
                            <option value="{{ config('constants.BOOKING_STATUS_COMPLETED') }}" {{ $booking->status == config('constants.BOOKING_STATUS_COMPLETED') ? 'selected' : '' }}>Completed</option>
                            
                            <option value="{{ config('constants.BOOKING_STATUS_IN_PROGRESS') }}" {{ $booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS') ? 'selected' : '' }}>In-Progress</option>

                            <option value="{{ config('constants.BOOKING_STATUS_ON_HOLD') }}" {{ $booking->status == config('constants.BOOKING_STATUS_ON_HOLD') ? 'selected' : '' }}>On-Hold</option>

                            <option value="{{ config('constants.BOOKING_STATUS_CANCELLED') }}" {{ $booking->status == config('constants.BOOKING_STATUS_CANCELLED') ? 'selected' : '' }}>Cancelled</option>
                        
                        </select>
                        @error('status') {{-- Update the name attribute to 'status' --}}
                        <span>{{ $message }}</span>
                        @enderror
                    </div>
            
                    <div class="form-field">
                        <button type="submit" class="default-button-v2">
                            <span>Save</span>
                        </button>
                    </div>
                </div>
            </form>

        </section>

        @endif
    </div>
</section>
@endsection