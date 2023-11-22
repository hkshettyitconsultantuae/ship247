@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-6/12">
                <h2 class="title">
                    customers
                </h2>
            </div>
            {{-- <div class="w-6/12">
                <form class="dashboard-searchbar" action="{{ route('superadmin.customers.index') }}" method="GET">
                    <input type="text" class="search-bar" name="search" placeholder="Search By: NAME, EMAIL AND NUMBER" value="{{ request('search') }}" />
                    <button class="submit-btn" type="submit">
                        <img src="/images/svg/search-icon.svg" alt="">
                    </button>
                </form>
            </div> --}}
            <div class="w-6/12 lg:justify-end justify-start flex">
                
            </div>
        </header>
        <section class="search-result mt-8 mb-12">
               
            <form class="default-form" action="{{ route('superadmin.customers.index') }}" method="GET">

                <div class="flex lg:items-end items-start lg:flex-row flex-col lg:gap-6 gap-4">
                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="name" class="form-label-small">Name</label>
                            <input type="text" name="name" id="name" class="form-input small-input w-full" placeholder="Filter by Name" value="{{ $name ?? '' }}">
                        </div>
                    </div>
            
                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="email" class="form-label-small">Email</label>
                            <input type="text" name="email" id="email" class="form-input small-input w-full" placeholder="Filter by Email" value="{{ $email ?? '' }}">
                        </div>
                    </div>
                    
                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="contact_number" class="form-label-small">Contact Number</label>
                            <input type="text" name="contact_number" id="contact_number" class="form-input small-input w-full" placeholder="Filter by Contact Number" value="{{ $contact_number ?? '' }}">
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
            @if(isset($customers) && count($customers) > 0)
            @foreach ($customers as $customer)
            <div class="detail-box relative lg:gap-0 gap-6 flex lg:flex-row flex-col">
        
                <div class="lg:w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">name</span>
                            <span class="value">{{$customer->first_name . " " . $customer->last_name}}</span>
                        </div>
                    </div>
                </div>

                <div class="lg:w-4/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">email</span>
                            <span class="value">{{$customer->email}}</span>
                        </div>
                    </div>
                </div>

                {{-- <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">phone number</span>
                            <span class="value">{{$customer->phone_number}}</span>
                        </div>
                    </div>
                </div> --}}

                <div class="lg:w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Number</span>
                            <span class="value">{{ $customer->phone_number }}</span>
                        </div>
                    </div>
                </div>
                
                {{-- <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">company name</span>
                            <span class="value">{{ $customer->company_name }}</span>
                        </div>
                    </div>
                </div> --}}

                <div class="lg:w-2/12">
                    <div class="flex justify-end items-center h-full">
                        <div>
                            <a href="{{route('superadmin.customer.detail', ['customerID' =>$customer->id ])}}"
                                class="default-button small-button red">view details</a>
                        </div>
                    </div>
                </div>

                {{-- <div class="w-2/12">
                    <div class="flex justify-end items-center h-full">
                        
                        <button id="dropdownUserButton{{$customer->id}}" data-dropdown-toggle="dropdownUser{{$customer->id}}" class="inline-flex justify-center items-center gap-x-1 rounded-md px-3 py-2 text-sm text-white primary-bg" type="button">
                            View More
                            <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownUser{{$customer->id}}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownUserButton{{$customer->id}}">
                                <li>
                                    <a href="{{route('superadmin.customer.detail', ['customerID' => $customer->id])}}" class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                        <span>View</span>
                                    </a>
                                </li>
                                <li>
                              

                                    <form action="{{route('superadmin.customer.delete', ['customerID' => $customer->id])}}" method="post">
                                        @csrf
                                        <input type="hidden" name="_method" value="POST">
                                        <button class="block px-4 py-2 hover:bg-red-600 hover:text-white" type="submit">Delete</button>
                                    </form>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
            @endforeach

            @else

            <div class="detail-box">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">No customers found.</span>
                    </div>
                </div>
            </div>
            @endif

        </div>
        <footer>
            <p class="number">Showing <strong>{{ $customers->firstItem() }} - {{ $customers->lastItem() }}</strong></p>
            {{ $customers->links() }}
       
        </footer>
    </div>
</section>

@endsection