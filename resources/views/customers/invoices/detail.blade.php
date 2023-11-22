@extends('layouts.admin')

@section('content')
<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <h2 class="title">
                Payments Details
            </h2>
            <div class="searchbar">

            </div>
            <div>
                <a href="{{route('customer.bookings.index')}}" class="default-button-v2">
                    <span>Back</span>
                </a>
            </div>
        </header>

        @if(isset($payment_details))
        <div class="detail-body">
            <div class="detail-box">
                <div class="w-12/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Payment ID</span>
                            <span class="value">{{ str_pad($payment_details->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        <div>
                            <span class="head">Client Secret </span>
                            <span class="value">{{$payment_details->client_secret}}</span>
                        </div>
                    </div>
                </div>

            

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">User</span>
                            <span class="value">{{ isset($payment_details->booking->user) ?
                                $payment_details->booking->user->first_name . ' '.
                                $payment_details->booking->user->last_name : '' }} </span>
                        </div>

                 
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">amount</span>
                            <span class="value">{{ '$' . number_format($payment_details->amount, 2) }}</span>
                        </div>

                        <div>
                            <span class="head">Date</span>
                            <span class="value">{{ date('d, M, Y', strtotime($payment_details->created_at))
                                }}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Booking ID</span>
                            <span class="value"> <a
                                    href="{{ route('customer.bookings.show', [$payment_details->booking->id]) }}"
                                    class="default-button small-button red">{{$payment_details->booking->id}}</a></span>

                        </div>

                  
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex justify-between flex-col items-end h-full">
                        <div>
                            @if($payment_details->status == config('constants.BOOKING_PAYMENT_SUCCESS'))
                            <span class="badge completed">
                                Completed
                            </span>
                            @endif
                            @if($payment_details->status == config('constants.BOOKING_PAYMENT_PENDING'))
                            <span class="badge progress">
                                Pending
                            </span>
                            @endif
                            @if($payment_details->status == config('constants.BOOKING_PAYMENT_FAILED'))
                            <span class="badge cancel">
                                Failed
                            </span>

                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <h2 class="title">
            Bookings Details
        </h2>
        @if(isset($payment_details->booking))
        <div class="detail-body">
            <div class="detail-box">
                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Booking ID</span>
                            <span class="value">{{ str_pad($payment_details->booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        <div>
                            <span class="head">No of Container</span>
                            <span class="value">{{$payment_details->booking->no_of_containers}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">from</span>
                            <span class="value">{{$payment_details->booking->origin->fullname}}</span>
                        </div>

                        <div>
                            <span class="head">Container</span>
                            <span class="value">{{$payment_details->booking->container_size}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">to</span>
                            <span class="value">{{isset($payment_details->booking->destination->fullname) ? $payment_details->booking->destination->fullname : ''}}</span>
                        </div>

                        <div>
                            <span class="head">product</span>
                            <span class="value">{{$payment_details->booking->product}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">amount</span>
                            <span class="value">{{ '$' . number_format($payment_details->booking->amount, 2) }}</span>
                        </div>

                        <div>
                            <span class="head">CARGO READY</span>
                            <span class="value">{{ date('d M y', strtotime($payment_details->booking->departure_date_time))
                                }}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Transportation</span>
                            <span class="value">{{$payment_details->booking->transportation}}</span>
                        </div>

                        <div>
                            <span class="head">Shipping line</span>
                            <span class="value">{{$payment_details->booking->company->name}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex justify-between flex-col items-end h-full">
                        <div>
                            @if($payment_details->booking->status == "COMPLETED")
                            <span class="badge completed">
                                Completed
                            </span>
                            @endif
                            @if($payment_details->booking->status == "IN-PROGRESS")
                            <span class="badge progress">
                                In-Progress
                            </span>
                            @endif
                            @if($payment_details->booking->status == "CANCELLED")
                            <span class="badge cancel">
                                Cancelled
                            </span>
                            @endif
                            @if($payment_details->booking->status == "ON-HOLD")
                            <span class="badge hold">
                                On-hold
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @endif


        <h2 class="title">
            Bookings Addons Details
        </h2>
        @if(isset($payment_details->booking->addons) && count($payment_details->booking->addons) > 0)
        @foreach ($payment_details->booking->addons as $addon)
        <p><strong>{{$addon->name}}: </strong> <span>{{$addon->value}}</span></p>
        @endforeach
        @endif
        @endif
    </div>
</section>
@endsection