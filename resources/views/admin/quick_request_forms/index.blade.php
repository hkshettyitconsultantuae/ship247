@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-6/12">
                <h2 class="title">
                    Quick Request Forms
                </h2>
            </div>
        </header>


        <section class="search-result mt-8 mb-12">

            <form class="default-form" action="{{ route('superadmin.quick-request-forms.index') }}" method="GET">

                <div class="flex lg:items-end items-start lg:flex-row flex-col lg:gap-6 gap-4">
                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="name" class="text-xs uppercase text-gray-400">Name</label>
                            <input type="text" name="name" id="name" class="form-input small-input w-full"
                                placeholder="Filter by Name" value="{{ $name ?? '' }}">
                        </div>
                    </div>

                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="email" class="text-xs uppercase text-gray-400">Email</label>
                            <input type="text" name="email" id="email" class="form-input small-input w-full"
                                placeholder="Filter by Email" value="{{ $email ?? '' }}">
                        </div>
                    </div>

                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="phone" class="text-xs uppercase text-gray-400">Contact Number</label>
                            <input type="text" name="phone" id="phone" class="form-input small-input w-full"
                                placeholder="Filter by Contact Number" value="{{ $phone ?? '' }}">
                        </div>
                    </div>

                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="company" class="text-xs uppercase text-gray-400">Company Name</label>
                            <input type="text" name="company" id="company" class="form-input small-input w-full"
                                placeholder="Filter by company" value="{{ $company ?? '' }}">
                        </div>
                    </div>

                    <div class="lg:w-3/12 w-full">
                        <button type="submit" class="default-button-v2 outline-button">
                            <span>Search</span>
                        </button>
                    </div>

                </div>

            </form>
        </section>

        <div class="detail-body mt-10">
            @if(isset($quick_request_forms) && count($quick_request_forms) > 0)
            @foreach ($quick_request_forms as $form)
            <div class="detail-box relative lg:gap-0 gap-6 flex lg:flex-row flex-col">
                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Full Name</span>
                            <span class="value">{{$form->name}}</span>
                        </div>

                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Email</span>
                            <span class="value">{{ $form->email }}</span>
                        </div>


                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Company Name</span>
                            <span class="value">{{ $form->company }}</span>
                        </div>

                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Route Type</span>
                            <span class="value">{{
                                $form->route_type == 1 ? 'SEA' : 'LAND'}}</span>
                        </div>

                    </div>
                </div>

                <div class="lg:w-2/12 lg:mt-0 mt-6">
                    <div class="flex justify-end items-center h-full">
                        <div>
                            <a href="{{route('superadmin.quick-request-form-detail', ['quickRequestID' => $form->id ])}}"
                                class="default-button small-button red">view details</a>
                        </div>
                    </div>
                </div>

            </div>
            @endforeach

            @else

            <div class="p-4 rounded-lg bg-gray-50">
                <p class="text-sm text-gray-500">No forms found</p>
            </div>
            @endif

        </div>

        <footer>
            {{ $quick_request_forms->links() }}
        </footer>
    </div>
</section>

@endsection