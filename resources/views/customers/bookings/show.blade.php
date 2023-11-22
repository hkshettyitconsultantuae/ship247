@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <h2 class="title">
                Bookings Details
            </h2>
            <div>
                <a href="{{route('customer.bookings.index')}}" class="default-button-v2 outline-button">
                    <span>back</span>
                </a>
            </div>
        </header>

        @if(isset($booking_details))
        <div class="detail-body">
            <div class="detail-box">
                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Booking ID</span>
                            <span class="value">{{ str_pad($booking_details->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        <div>
                            <span class="head">No of Container</span>
                            <span class="value">{{$booking_details->no_of_containers}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">from</span>
                            <span class="value">{{$booking_details->origin}}</span>
                        </div>

                        <div>
                            <span class="head">Container</span>
                            <span class="value">{{$booking_details->container_size}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">to</span>
                            <span class="value">{{$booking_details->destination}}</span>
                        </div>

                        <div>
                            <span class="head">product</span>
                            <span class="value">{{$booking_details->product}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">amount</span>
                            <span class="value">{{ '$' . number_format($booking_details->amount, 2) }}</span>
                        </div>

                        <div>
                            <span class="head">CARGO READY</span>
                            <span class="value">{{ date('d M y', strtotime($booking_details->departure_date_time))
                                }}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Transportation</span>
                            <span class="value">{{$booking_details->transportation}}</span>
                        </div>

                        <div>
                            <span class="head">Shipping line</span>
                            <span class="value">{{$booking_details->shipping_line}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex justify-between flex-col items-end h-full">
                        <div>
                            @if($booking_details->status == "COMPLETED")
                            <span class="badge completed">
                                Completed
                            </span>
                            @endif
                            @if($booking_details->status == "IN-PROGRESS")
                            <span class="badge progress">
                                In-Progress
                            </span>
                            @endif
                            @if($booking_details->status == "CANCELLED")
                            <span class="badge cancel">
                                Cancelled
                            </span>
                            @endif
                            @if($booking_details->status == "ON-HOLD")
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