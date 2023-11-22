@extends('layouts.admin')

@section('content')
<section class="shadow-box small-box mt-8">
    <div class="dashboard-detail-box">


        @if(isset($booking_details))
        <div class="invoice-body">
            <div class="flex items-center justify-between">
                <p class="text-xl font-bold">
                    ID# 99101 INVOICE
                </p>

                <div>
                    <a href="#" class="default-button-v2 primary-bg">
                        <span>download</span>
                    </a>
                </div>
            </div>

            <table class="invoice-table">
                <tr>
                    <td>
                        <span class="head">Origin</span>
                        <span class="value">{{$booking_details->origin}}</span>
                    </td>

                    <td>
                        <span class="head">Destination</span>
                        <span class="value">{{$booking_details->destination}}</span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span class="head">Date</span>
                        <span class="value">{{ date('d M y', strtotime($booking_details->departure_date_time)) }}</span>
                    </td>

                    <td>
                        <span class="head">Container Size</span>
                        <span class="value">{{$booking_details->container_size}}</span>
                    </td>
                </tr>
            </table>

            <hr class="border-t-2 border-purple-950">

            <table class="invoice-table detail">
                <tr>
                    <td>
                        <span class="head">Pickup Charges</span>
                    </td>

                    <td>
                        <span class="value">$999</span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span class="head">Origin Port Charges</span>
                    </td>

                    <td>
                        <span class="value">$999</span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span class="head">Destination Port Charges</span>
                    </td>

                    <td>
                        <span class="value">$999</span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span class="head">Freight Charges</span>
                    </td>

                    <td>
                        <span class="value">$999</span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span class="head">Delivery Charges</span>
                    </td>

                    <td>
                        <span class="value">$999</span>
                    </td>
                </tr>
            </table>

            <hr class="border-t-2 border-purple-950">

            <table class="invoice-table price">
                <tr>
                    <td>

                    </td>

                    <td>
                        <span class="value text-3xl">$4999</span>
                    </td>
                </tr>
            </table>

                        {{-- <div>
                            <span class="head">ID</span>
                            <span class="value"># {{ str_pad($booking_details->id, 5, '0', STR_PAD_LEFT) }}
                                Invoice</span>
                        </div>

                        <div>
                            <span class="head">BL</span>
                            <span class="value">22317899</span>
                        </div>
                        <div>
                            <span class="head">Origin</span>
                            <span class="value">{{$booking_details->origin}}</span>
                        </div>

                        <div>
                            <span class="head">Destination</span>
                            <span class="value">{{$booking_details->destination}}</span>
                        </div>

                        <div>
                            <span class="head">Date</span>
                            <span class="value">{{ date('d M y', strtotime($booking_details->departure_date_time))
                                }}</span>
                        </div>

                        <div>
                            <span class="head">product</span>
                            <span class="value">{{$booking_details->product}}</span>
                        </div>

                        <div>
                            <span class="head">Container Free Time</span>
                            <span class="value"> 7 Days</span>
                        </div>


            <div class="detail-box">


                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Shipment Charges</span>
                            <span class="value">{{ '$' . number_format(100, 2) }}</span>
                        </div>
                        <div>
                            <span class="head">Amount</span>
                            <span class="value">{{ '$' . number_format($booking_details->amount, 2) }}</span>
                        </div>


                    </div>

                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <h4>Addons Charges</h4>

                        </div>

                        @if(isset($booking_details->addons) && count($booking_details->addons) >0)
                        @foreach ( $booking_details->addons as $addon)
                        <div>
                            <span class="head">{{$addon->details->name}}</span>
                            <span class="value">{{$addon->details->type == "toggle" ? '$' . number_format($addon->value, 2)  : $addon->value}}</span>
                        </div>



                        @endforeach
                        @endif

                    </div>

                </div> --}}

            </div>
            @endif

        </div>
</section>

@endsection
