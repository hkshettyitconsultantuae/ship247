@extends('layouts.admin')

@section('content')
    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <div class="w-3/12">
                    <h2 class="title">
                        LAND pricing
                    </h2>
                </div>

                <div class="w-3/12 justify-end flex">
                    <a href="{{route('superadmin.land-schedules.create')}}" class="default-button-v2">
                        <span>ADD land pricing</span>
                    </a>
                </div>
            </header>

            <section class="search-result mt-8 mb-12">
                <form action="{{route('superadmin.land-schedules.index')}}" class="default-form">
                    <div class="flex items-end justify-between flex-row gap-4">
                        <div class="md:w-5/12">
                            <div class="flex gap-4">
                                <div class="w-6/12">
                                    <div class="form-field">
                                        <label for="origin_id" class="text-xs uppercase text-gray-400">Origin</label>
                                        @include('admin.partials._location-select2',
                                            [
                                                'name' => 'origin_id',
                                                'selected_option_value' => $origin->id ?? null,
                                                'selected_option_text' => $origin->fullname ?? null,
                                            ]
                                        )
                                    </div>
                                </div>

                                <div class="w-6/12">
                                    <div class="form-field">
                                        <label for="destination_id" class="text-xs uppercase text-gray-400">Destination</label>
                                        @include('admin.partials._location-select2',
                                            [
                                                'name' => 'destination_id',
                                                'selected_option_value' => $destination->id ?? null,
                                                'selected_option_text' => $destination->fullname ?? null,
                                            ]
                                        )
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:w-4/12">
                            <div class="flex gap-4">
                                <div class="w-6/12">
                                    <div class="form-field">
                                        <label for="truck_type_id" class="text-xs uppercase text-gray-400">Truck Type</label>
                                        <select id="truck_type_id" name="truck_type_id"
                                                class="form-input small-input w-full">
                                            <option value="">Select Truck Type</option>
                                            @foreach($truck_types as $truck_type_id => $truck_type_label)
                                                <option value="{{ $truck_type_id }}"
                                                        @if($truck_type && $truck_type->id == $truck_type_id) selected @endif
                                                >{{$truck_type_label}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="w-6/12">
                                    <div class="form-field">
                                        <label for="axle" class="text-xs uppercase text-gray-400">Axle</label>
                                        <select id="axle" name="axle"
                                                class="form-input small-input w-full">
                                            <option value="">Select Axle</option>
                                            @foreach($axles as $value => $label)
                                                <option value="{{ $value }}"
                                                        @if($axle === $value) selected @endif
                                                >{{$label}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:w-2/12">
                            <div class="form-field">
                                <label for="company_id" class="text-xs uppercase text-gray-400">Company</label>
                                <select id="company_id" name="company_id"
                                        class="form-input small-input w-full">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company_id => $company_name)
                                        <option value="{{ $company_id }}"
                                                @if($company && $company->id == $company_id) selected @endif
                                        >{{$company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="md:w-1/12 justify-end flex">
                            <button type="submit" class="default-button-v2 small-button outline-button">
                                <span>Search</span>
                            </button>
                        </div>

                    </div>
                </form>
            </section>

            <div class="detail-body mt-10">
                @if(isset($landSchedules) && count($landSchedules) > 0)
                    @foreach ($landSchedules as $landSchedule)
                        <div class="detail-box relative">
                            <div class="w-6/14">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Pick Up Point</span>
                                        <span class="value">{{$landSchedule->origin->fullname}}</span>
                                    </div>
                                    <div>
                                        <span class="head">Delivery Point</span>
                                        <span class="value">{{$landSchedule->destination->fullname}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/14">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Truck Type</span>
                                        <span class="value">{{$landSchedule->truckType->display_label}}</span>
                                    </div>

                                    <div>
                                        <span class="head">Axle</span>
                                        <span
                                            class="value">{{$landSchedule->axle ? $landSchedule->axle." axle" : 'None'}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/14">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Max Load in Ton</span>
                                        <span class="value">{{number_format($landSchedule->max_load_in_ton, 2)}}</span>
                                    </div>

                                    <div>
                                        <span class="head">Land Freight</span>
                                        <span class="value">{{'$'.number_format($landSchedule->land_freight, 2)}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/14">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Container</span>
                                        <span class="value">{{$landSchedule->container_size
                                            ? $landSchedule->containerSize->display_label : '-'}}</span>
                                    </div>
                                    <div>
                                        <span class="head">Company</span>
                                        <span class="value">{{ $landSchedule->company->name}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/14">
                                <div class="flex justify-end items-center h-full">

                                    <button id="dropdownScheduleButton" data-dropdown-toggle="dropdownSchedule-{{$landSchedule->id}}"
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
                                    <div id="dropdownSchedule-{{$landSchedule->id}}"
                                         class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownScheduleButton">
                                            <li>
                                                <a href="{{route('superadmin.land-schedules.edit', [$landSchedule->id])}}"
                                                   class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                                    <span>Edit Details</span>
                                                </a>
                                            </li>
                                            <li>
                                                <form
                                                    action="{{route('superadmin.land-schedules.destroy', [$landSchedule->id])}}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="block px-4 py-2 hover:bg-red-600 hover:text-white"
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
                    <div class="p-4 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-500">No pricing found</p>
                    </div>
                @endif

            </div>

            <footer>
                {{ $landSchedules->links() }}
            </footer>
        </div>
    </section>
@endsection
