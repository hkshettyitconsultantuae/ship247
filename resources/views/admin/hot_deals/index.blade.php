@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-3/12">
                <h2 class="title">
                    {{ request()->route_type_name }} Hot Deals
                </h2>
            </div>

            <div class="w-3/12 justify-end flex">
                <a href="{{route('superadmin.'.request()->route_type_addition.'-hot-deals.create')}}" class="default-button-v2">
                    <span>Add {{ request()->route_type_name }}  Hot Deals</span>
                </a>
            </div>
        </header>

        <div class="detail-body mt-10">
            @if(isset($hot_deals) && count($hot_deals) > 0)
            @foreach ($hot_deals as $hot_deal)
            <div class="detail-box relative">
                <div class="w-6/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Origin</span>
                            <span class="value">{{$hot_deal->origin->fullname}}</span>
                        </div>
                        <div>
                            <span class="head">Destination</span>
                            <span class="value">{{$hot_deal->destination->fullname}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Start Date</span>
                            <span class="value">{{ $hot_deal->start_date->format('d/m/Y') }}</span>
                        </div>

                        <div>
                            <span class="head">End Date</span>
                            <span class="value">{{ $hot_deal->end_date->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">ETD</span>
                            <span class="value">{{ $hot_deal->etd->format('d/m/Y') }}</span>
                        </div>

                        <div>
                            <span class="head">ETA</span>
                            <span class="value">{{ $hot_deal->eta->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">TT</span>
                            <span class="value">{{$hot_deal->tt}} days</span>
                        </div>

                        <div>
                            <span class="head">Amount</span>
                            <span class="value">${{$hot_deal->amount}}</span>
                        </div>
                    </div>
                </div>


                <div class="w-2/12">
                    <div class="flex justify-end items-start h-full">

                        <button id="hotDealButton" data-dropdown-toggle="hotDeal-{{$hot_deal->id}}"
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
                        <div id="hotDeal-{{$hot_deal->id}}"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="hotDealButton">
                                <li>
                                    <a href="{{route('superadmin.'.request()->route_type_addition.'-hot-deals.edit', ['hot_deal' => $hot_deal->id])}}" class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                        <span>Edit</span>
                                    </a>
                                </li>
                                <li>
                                    <form action="{{route('superadmin.'.request()->route_type_addition.'-hot-deals.destroy', ["hot_deal" =>$hot_deal->id])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="block px-4 py-2 hover:bg-red-600 hover:text-white" type="submit">Delete</button>
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
                <p class="text-sm text-gray-500">No hot deals found</p>
            </div>
            @endif

        </div>

        <footer>
            {{ $hot_deals->links() }}
        </footer>
    </div>
</section>

@endsection
