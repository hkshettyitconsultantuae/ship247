<div class="detail-box gap-4 relative">
    <div class="absolute left-4 -top-3">
        @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
            <span class="badge completed small-badge">Completed</span>
        @elseif($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
            <span class="badge progress small-badge">In-Progress</span>
        @elseif($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
            <span class="badge cancel small-badge">Cancelled</span>
        @elseif($booking->status == config('constants.BOOKING_STATUS_ON_HOLD'))
            <span class="badge hold small-badge">On-hold</span>
        @endif
    </div>

    <div class="lg:w-2/12 lg:mb-0 mb-4">
        <div class="flex flex-col gap-4">
            <div>
                <span class="head">Booking ID</span>
                <span class="value">{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} </span>
            </div>
            <div>
                <span class="head">BL Number</span>
                <span class="value">{{isset($booking->shipping_number) ? $booking->shipping_number : '-'}}</span>
            </div>
        </div>
    </div>

    <div class="lg:w-4/12">
        <div class="flex flex-col gap-4">
            <div>
                <span class="head">from</span>
                <span class="value">{{isset($booking->origin->fullname) ? $booking->origin->fullname : ''}}</span>
            </div>

            <div>
                <span class="head">to</span>
                <span class="value">{{isset($booking->destination->fullname) ?$booking->destination->fullname : '' }}</span>
            </div>
        </div>
    </div>

    <div class="lg:w-2/12 lg:mt-0 mt-4">
        <div class="flex flex-col gap-4">
            <div>
                <span class="head">No of Container</span>
                <span class="value">{{$booking->no_of_containers}}</span>
            </div>

            <div>
                <span class="head">Container</span>
                <span class="value">{{$booking->container_size}}</span>
            </div>
        </div>
    </div>

    <div class="lg:w-2/12 lg:mt-0 mt-4">
        <div class="flex flex-col gap-4">
            <div>
                <span class="head">amount</span>
                <span class="value">{{ '$' . number_format($booking->amount, 2) }}</span>
            </div>

            <div>
                <span class="head">Shipping line</span>
                <span class="value">{{isset($booking->company) ? $booking->company->name : ''}}</span>
            </div>
        </div>
    </div>

    <div class="lg:w-2/12 w-full lg:mt-0 mt-6">
        <div class="flex lg:justify-end items-start h-full">

            <button id="dropdownInvoiceButton" data-dropdown-toggle="dropdownInvoice-{{$booking->id}}"
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
            <div id="dropdownInvoice-{{$booking->id}}"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownInvoiceButton">
                    <li>
                        <a href="{{ route('superadmin.bookings.edit', [$booking->id]) }}"
                            class="block px-4 py-2 hover:bg-red-600 hover:text-white">Edit </a>
                    </li>
                    <li>
                        <a href="{{ route('superadmin.bookings.show', [$booking->id]) }}"
                            class="block px-4 py-2 hover:bg-red-600 hover:text-white">View Details</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- <div class="lg:w-2/12 lg:mt-0 mt-6">
        <div class="flex justify-end items-center h-full">
            <div>
                <a href="{{ route('superadmin.bookings.show', [$booking->id]) }}"
                   class="default-button small-button red">view details</a>
            </div>
            <div>
                <a href="{{ route('superadmin.bookings.edit', [$booking->id]) }}"
                   class="default-button small-button red">Edit </a>
            </div>
        </div>
    </div> --}}
</div>
