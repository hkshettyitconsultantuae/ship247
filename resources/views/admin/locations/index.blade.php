@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-3/12">
                <h2 class="title">
                    LOCATIONS
                </h2>
            </div>
            <div class="w-6/12">
                <form class="dashboard-searchbar">
                    <input type="text" class="search-bar" placeholder="Search By : BL, SHIPPING LINE, POO, POD, AMOUNT, TRANSPORTATION, STATUS ETC. …." />
                    <button class="submit-btn">
                        <img src="/images/svg/search-icon.svg" alt="">
                    </button>
                </form>
            </div>
            <div class="w-3/12 justify-end flex">
                <a href="{{route('superadmin.locations.create')}}" class="default-button-v2">
                    <span>Create Location</span>
                </a>
            </div>
        </header>


        <section class="search-result mt-8 mb-12">

            <form class="default-form" action="{{ route('superadmin.locations.index') }}" method="GET">

                <div class="flex items-start flex-row gap-4">
                    <div class="md:w-10/12">
                        <div class="flex gap-4">

                            <div class="w-6/12">
                                <div class="form-field">
                                    <label for="country" class="text-xs uppercase text-gray-400">COUNTRY</label>
                                    <input type="text" name="country" id="country" class="form-input small-input w-full"
                                        placeholder="Filter by COUNTRY" value="{{ $country ?? '' }}">
                                </div>
                            </div>
                            <div class="w-6/12">
                                <div class="form-field">
                                    <label for="city" class="text-xs uppercase text-gray-400">City</label>
                                    <input type="text" name="city" id="city" class="form-input small-input w-full"
                                        placeholder="Filter by City" value="{{ $city ?? '' }}">
                                </div>
                            </div>

                            <div class="w-6/12">
                                <div class="form-field">
                                    <label for="port" class="text-xs uppercase text-gray-400">Port</label>
                                    <input type="text" name="port" id="port" class="form-input small-input w-full"
                                        placeholder="Filter by Port" value="{{ $port ?? '' }}">
                                </div>
                            </div>
                            <div class="w-6/12">
                                <div class="form-field">
                                    <label for="code" class="text-xs uppercase text-gray-400">code</label>
                                    <input type="text" name="code" id="code" class="form-input small-input w-full"
                                        placeholder="Filter by code" value="{{ $code ?? '' }}">
                                </div>
                            </div>
                            <div class="w-6/12">
                                <div class="form-field">
                                    <label for="geo_id" class="text-xs uppercase text-gray-400">GEO ID</label>
                                    <input type="text" name="geo_id" id="geo_id" class="form-input small-input w-full"
                                        placeholder="Filter by geo_id" value="{{ $geo_id ?? '' }}">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="md:w-5/12">
                        <div class="flex gap-4">

                            <div class="w-6/12">
                                <button type="submit" class="default-button-v2 small-button outline-button">
                                    <span>Search</span>
                                </button>
                            </div>
                        </div>

                    </div>


                </div>

            </form>
        </section>

        <div class="detail-body mt-10">
            @if(isset($locations) && count($locations) > 0)
            @foreach ($locations as $location)
            <div class="detail-box relative">
                {{-- <div class="absolute left-4 -top-3">
                    <span class="badge progress small-badge">{{"Active"}}</span>
                </div> --}}
                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Location ID</span>
                            <span class="value uppercase">{{ str_pad($location->id, 5, '0', STR_PAD_LEFT) }} </span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Country</span>
                            <span class="value uppercase">{{$location->country->name}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">City</span>
                            <span class="value uppercase">{{$location->city}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Port</span>
                            <span class="value uppercase">{{$location->port}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Code</span>
                            <span class="value uppercase">{{$location->code}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Maersk Geo ID</span>
                            <span class="value">{{$location->maersk_geo_id}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex justify-end items-center h-full">

                        <button id="dropdownLocationButton" data-dropdown-toggle="dropdownLocation-{{$location->id}}"
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
                        <div id="dropdownLocation-{{$location->id}}"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownLocationButton">
                                {{-- <li>
                                    <a href="{{route('superadmin.locations.edit', $location->id)}}" class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                        <span>Edit</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <form action="{{route('superadmin.locations.destroy', $location->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="block px-4 py-2 w-full text-left hover:bg-red-600 hover:text-white" type="submit">Delete</button>
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
                <p class="text-sm text-gray-500">No locations found</p>
            </div>
            @endif

        </div>

        <footer>
            {{ $locations->links() }}
        </footer>
    </div>
</section>

@endsection
