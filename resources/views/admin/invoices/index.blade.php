@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-3/12">
                <h2 class="title">
                    PAYMENTS
                </h2>
            </div>
            <div class="w-6/12">
                <form class="dashboard-searchbar" action="{{ route('superadmin.invoices.index') }}" method="GET">
                    <input type="text" class="search-bar" name="search" placeholder="Search By: BL, SHIPPING LINE, POO, POD, AMOUNT, TRANSPORTATION, STATUS ETC. …." value="{{ request('search') }}" />
                    <button class="submit-btn" type="submit">
                        <img src="/images/svg/search-icon.svg" alt="">
                    </button>
                </form>
            </div>
            <div class="w-3/12 justify-end flex">

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
                        <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="cleared-tab"
                            data-tabs-target="#cleared" type="button" role="tab" aria-controls="cleared"
                            aria-selected="false">Cleared</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="pending-tab"
                            data-tabs-target="#pending" type="button" role="tab" aria-controls="pending"
                            aria-selected="false">Pending</button>
                    </li>
                </ul>
            </div>
        </div>

        <div id="myTabContent">
            <div class="" id="all" role="tabpanel" aria-labelledby="all-tab">
                <div class="detail-body">
                    @if(isset($payments) && count($payments) > 0)
                    @foreach ($payments as $payment)
                    <div class="detail-box relative">
                        <div class="absolute left-4 -top-3">
                            <span class="badge progress small-badge">{{$payment->status }}</span>
                        </div>
                        <div class="w-2/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Payment ID</span>
                                    <span class="value">{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }} </span>
                                </div>


                            </div>
                        </div>
                        <div class="w-2/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">User</span>
                                    <span class="value">{{ isset($payment->booking->user) ?  $payment->booking->user->first_name . ' '.  $payment->booking->user->last_name : '' }} </span>
                                </div>


                            </div>
                        </div>



                        <div class="w-2/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">amount</span>
                                    <span class="value">{{ '$' . number_format($payment->amount, 2) }}</span>
                                </div>

                            </div>
                        </div>
                        <div class="w-2/12">
                            <div class="flex justify-center items-center h-full">
                                <div>
                                    @if($payment->status == config('constants.BOOKING_PAYMENT_SUCCESS') )
                                    <span class="badge completed">
                                        Completed
                                    </span>
                                    @endif
                                    @if($payment->status == config('constants.BOOKING_PAYMENT_PENDING') )
                                    <span class="badge progress">
                                        Pending
                                    </span>
                                    @endif
                                    @if($payment->status ==  config('constants.BOOKING_PAYMENT_FAILED')  )
                                    <span class="badge cancel">
                                        Failed
                                    </span>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="w-2/12">
                            <div class="flex justify-end items-center h-full">

                                <button id="dropdownInvoiceButton{{$payment->id}}"
                                    data-dropdown-toggle="dropdownInvoice{{$payment->id}}"
                                    class="inline-flex justify-center items-center gap-x-1 rounded-md px-3 py-2 text-sm text-white primary-bg"
                                    type="button">
                                    View More
                                    <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div id="dropdownInvoice{{$payment->id}}"
                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                                    <ul class="py-2 text-sm text-gray-700"
                                        aria-labelledby="dropdownInvoiceButton{{$payment->id}}">
                                        <li>
                                            <a href="{{route('superadmin.booking.invoice', ['paymentID' => $payment->id])}}"
                                                class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                                <span>View Details</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('superadmin.booking.invoice', ['paymentID' => $payment->id])}}"
                                                class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                                <span>Invoice</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @else
                    <div class="p-4 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-500">No invoice found</p>
                    </div>
                    @endif

                </div>
            </div>

            <div class="hidden" id="cleared" role="tabpanel" aria-labelledby="cleared-tab">
                <p class="text-sm text-gray-500">Show all uncleared list1</p>
            </div>

            <div class="hidden" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                <div class="detail-body">
                    <div class="detail-box relative">
                        @if(!empty($payment))
                        <div class="absolute left-4 -top-3">
                            <span class="badge progress small-badge">{{$payment->status }}</span>
                        </div>
                        <div class="w-2/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Booking ID</span>
                                    <span class="value">{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }} </span>
                                </div>
                            </div>
                        </div>

                        <div class="w-3/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">from</span>
                                    <span class="value">{{$payment->origin}}</span>
                                </div>

                                {{-- <div>
                                    <span class="head">to</span>
                                    <span class="value">{{$payment->destination}}</span>
                                </div> --}}
                            </div>
                        </div>

                        <div class="w-3/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">to</span>
                                    <span class="value">{{$payment->destination}}</span>
                                </div>


                            </div>
                        </div>

                        <div class="w-2/12">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">amount</span>
                                    <span class="value">{{ '$' . number_format($payment->amount, 2) }}</span>
                                </div>

                            </div>
                        </div>

                        <div class="w-2/12">
                            <div class="flex justify-end items-center h-full">

                                <button id="dropdownInvoiceButton" data-dropdown-toggle="dropdownInvoice"
                                    class="inline-flex justify-center items-center gap-x-1 rounded-md px-3 py-2 text-sm text-white primary-bg"
                                    type="button">
                                    View More
                                    <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div id="dropdownInvoice"
                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownInvoiceButton">
                                        <li>
                                            <a href="{{route('superadmin.booking.invoice', ['paymentID' => $payment->id])}}"
                                                class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                                <span>View Details</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('superadmin.booking.invoice', ['paymentID' => $payment->id])}}"
                                                class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                                <span>Invoice</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <footer>
            <p class="number">Showing <strong>{{ $payments->firstItem() }} - {{ $payments->lastItem() }}</strong></p>
            {{ $payments->links() }}
            {{-- <p class="total">Total <strong>{{ $payments->total() }}</strong></p> --}}
        </footer>
    </div>
</section>

@endsection
