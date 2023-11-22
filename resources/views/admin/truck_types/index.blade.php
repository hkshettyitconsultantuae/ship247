@extends('layouts.admin')

@section('content')
    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <div class="w-3/12">
                    <h2 class="title">
                        Truck Types
                    </h2>
                </div>

                <div class="w-3/12 justify-end flex">
                    <a href="{{route('superadmin.truck-types.create')}}" class="default-button-v2">
                        <span>Add Truck Type</span>
                    </a>
                </div>
            </header>

            <div class="detail-body mt-10">
                @if(isset($truck_types) && count($truck_types) > 0)
                    @foreach ($truck_types as $truck_type)
                        <div class="detail-box relative">
                            <div class="w-1/12">
                                <div class="flex flex-row gap-4">
                                    <div>
                                        <span class="head">ID</span>
                                        <span class="value">{{$truck_type->id}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w-8/12">
                                <div class="flex flex-row gap-4">
                                    <div>
                                        <span class="head">Display Label</span>
                                        <span class="value">{{$truck_type->display_label}}</span>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="w-3/12">
                                <div class="flex flex-row gap-4">
                                    <div>
                                        <span class="head">Created At</span>
                                        <span class="value">{{$truck_type->created_at->format('d/m/Y H:ia')}}</span>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="w-2/12">
                                <div class="flex justify-end items-start h-full">

                                    <button id="dropdownInvoiceButton"
                                            data-dropdown-toggle="dropdownInvoice-{{$truck_type->id}}"
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
                                    <div id="dropdownInvoice-{{$truck_type->id}}"
                                         class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownInvoiceButton">
                                            <li>
                                                <a href="{{route('superadmin.truck-types.edit', ['truckType' => $truck_type->id])}}"
                                                   class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                                    <span>Edit</span>
                                                </a>
                                            </li>
                                            <li>
                                                <form
                                                    action="{{route('superadmin.truck-types.destroy', ["truckType" => $truck_type->id])}}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="block px-4 py-2 hover:bg-red-600 hover:text-white text-left w-full" type="submit">Delete</button>
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
                        <p class="text-sm text-gray-500">No Truck Types found</p>
                    </div>
                @endif
            </div>

            <footer>
                {{ $truck_types->links() }}
            </footer>
        </div>
    </section>
@endsection
