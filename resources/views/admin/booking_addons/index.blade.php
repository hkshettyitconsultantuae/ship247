@extends('layouts.admin')

@section('content')
    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <h2 class="title">
                    {{ request()->route_type_name }} Booking Addons
                </h2>
                <div>
                    <a href="{{route('superadmin.'.request()->route_type_addition.'-booking-addons.create')}}" class="default-button-v2">
                        <span>Create {{ request()->route_type_name }} Addon</span>
                    </a>
                </div>
            </header>
            <div class="detail-body mt-8">
                @if(isset($bookingAddons) && count($bookingAddons) > 0)
                    @foreach ($bookingAddons as $booking_addon)
                        <div class="detail-box relative mb-8">
                            <div class="absolute left-4 -top-4">
                                @if ($booking_addon->status)
                                    <span class="badge success small-badge">Active</span>
                                @else
                                    <span class="badge cancel small-badge">Inactive</span>
                                @endif
                            </div>

                            <div class="w-4/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">name</span>
                                        <span class="value">{{$booking_addon->name}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-4/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">default Value</span>
                                        <span class="value">{{$booking_addon->default_value}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Type</span>
                                        <span class="value">{{ucfirst($booking_addon->type)}}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="w-2/12">
                                <div class="flex justify-end items-center h-full">
                                    <button id="dropdownAddonsButton"
                                            data-dropdown-toggle="dropdownAddons{{$booking_addon->id}}"
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
                                    <div id="dropdownAddons{{$booking_addon->id}}"
                                         class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownAddonsButton">
                                            <li>
                                                <a href="{{route('superadmin.'.request()->route_type_addition.'-booking-addons.edit', ["booking_addon" =>$booking_addon->id])}}"
                                                   class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                                    <span>Edit</span>
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('superadmin.'.request()->route_type_addition.'-booking-addons.destroy',
                                                            ["booking_addon" =>$booking_addon->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="block px-4 py-2 hover:bg-red-600 hover:text-white text-left w-full"
                                                        type="submit">Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="detail-box">
                        <div class="flex flex-col gap-4">
                            <div>
                                <span class="head">No booking addons found.</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
