@extends('layouts.admin')

@section('content')

    @if(isset($_GET['imported_rows']) && is_numeric($_GET['imported_rows']) && $_GET['imported_rows'] > 0)
        <h3>{{ $_GET['imported_rows'] }} rows were imported successfully!</h3>
    @endif

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-6/12">
                <h2 class="title">
                    PICK AND DELIVERY SCHEDULES
                </h2>
            </div>

            <div class="w-6/12 justify-end flex">
                <a href="{{route('superadmin.pick-and-delivery-schedules.create')}}" class="default-button-v2">
                    <span>ADD schedule</span>
                </a>

                <a href="#" data-modal-target="import-modal" data-modal-toggle="import-modal" class="default-button-v2 ml-4">
                    <span>import</span>
                </a>
            </div>
        </header>

        <section class="search-result mt-8 mb-12">
            <form action="" class="default-form">
                <div class="flex lg:items-end items-start lg:flex-row flex-col lg:gap-6 gap-4">
                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="" class="text-xs uppercase text-gray-400">Origin</label>
                            <input type="text" class="form-input small-input w-full">
                        </div>
                    </div>

                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="" class="text-xs uppercase text-gray-400">Destination</label>
                            <input type="text" class="form-input small-input w-full">
                        </div>
                    </div>

                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="" class="text-xs uppercase text-gray-400">Company</label>
                            <input type="text" class="form-input small-input w-full">
                        </div>
                    </div>

                    <div class="lg:w-3/12 w-full">
                        <button type="button" class="default-button-v2 outline-button">
                            <span>Search</span>
                        </button>
                    </div>

                </div>
            </form>
        </section>

        <div class="detail-body mt-10">
            @if(isset($pickAndDeliverySchedules) && count($pickAndDeliverySchedules) > 0)
            @foreach ($pickAndDeliverySchedules as $pickAndDeliverySchedule)
            <div class="detail-box relative lg:gap-0 gap-6 flex lg:flex-row flex-col">
                <div class="lg:w-4/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Origin</span>
                            <span class="value">{{$pickAndDeliverySchedule->origin->fullname}}</span>
                        </div>
                        <div>
                            <span class="head">Destination</span>
                            <span class="value">{{$pickAndDeliverySchedule->destination->fullname}}</span>
                        </div>
                    </div>
                </div>

                <div class="lg:w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Price</span>
                            <span class="value">{{'$'.number_format($pickAndDeliverySchedule->price, 2)}}</span>
                        </div>

                        <div>
                            <span class="head">Valid Till</span>
                            <span class="value">{{$pickAndDeliverySchedule->valid_till->format('d/m/Y')}}</span>
                        </div>
                    </div>
                </div>

                <div class="lg:w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Container</span>
                            <span class="value">{{$pickAndDeliverySchedule->containerSize->display_label}}</span>
                        </div>
                        <div>
                            <span class="head">Company</span>
                            <span class="value">{{ $pickAndDeliverySchedule->company->name}}</span>
                        </div>
                    </div>
                </div>

                <div class="lg:w-2/12">
                    <div class="flex justify-end items-center h-full">

                        <button id="dropdownScheduleButton" data-dropdown-toggle="dropdownSchedule-{{$pickAndDeliverySchedule->id}}"
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
                        <div id="dropdownSchedule-{{$pickAndDeliverySchedule->id}}"
                             class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownScheduleButton">
                                <li>
                                    <a href="{{route('superadmin.pick-and-delivery-schedules.edit', [$pickAndDeliverySchedule->id])}}"
                                       class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                        <span>Edit Details</span>
                                    </a>
                                </li>
                                <li>
                                    <form action="{{route('superadmin.pick-and-delivery-schedules.destroy', [$pickAndDeliverySchedule->id])}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="block px-4 py-2 hover:bg-red-600 hover:text-white w-full text-left" type="submit">Delete</button>
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
                    <p class="text-sm text-gray-500">No schedules found</p>
                </div>
            @endif

        </div>

        <footer>
            {{ $pickAndDeliverySchedules->links() }}
        </footer>
    </div>
</section>

<div id="import-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full" style="background: rgba(0, 0, 0, 0.6)">
    <div class="relative w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="import-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>

            <div class="p-6">
                <form method="POST" action="{{ route('superadmin.pick-and-delivery-schedules.import') }}"
                    enctype="multipart/form-data" class="default-form">
                    @csrf
                    <div class="grid gap-8 mt-4">
                        <div class="form-field">
                            <label for="import_file" class="form-label">Import File</label>
                            <input type="file" id="import_file" name="import_file" required
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                class="form-input small-input mt-2 w-full block">
                        </div>

                        <div class="form-field">
                            <button type="submit" class="default-button-v2">
                                <span>Upload</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
