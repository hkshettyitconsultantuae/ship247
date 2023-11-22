@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-6/12">
                <h2 class="title">
                    Employee List
                </h2>
            </div>
            {{-- <div class="w-6/12">
                <form class="dashboard-searchbar" action="{{ route('superadmin.user.index') }}" method="GET">
                    <input type="text" class="search-bar" name="search" placeholder="Search By: NAME, EMAIL, NUMBER, ROLE" value="{{ request('search') }}" />
                    <button class="submit-btn" type="submit">
                        <img src="/images/svg/search-icon.svg" alt="">
                    </button>
                </form>
            </div> --}}
            <div class="w-6/12 md:justify-end flex">
                <a href="{{route('superadmin.user.create')}}" class="default-button-v2">
                    <span>Add Employees</span>
                </a>
            </div>
        </header>

        <section class="search-result mt-8 mb-12">
               
            <form class="default-form" action="{{ route('superadmin.user.index') }}" method="GET">

                <div class="flex lg:items-end items-start lg:flex-row flex-col lg:gap-6 gap-4">
                    
                    <div class="lg:w-4/12 w-full">
                        <div class="form-field">
                            <label for="name" class="text-xs uppercase text-gray-400">Name</label>
                            <input type="text" name="name" id="name" class="form-input small-input w-full" placeholder="Filter by Name" value="{{ $name ?? '' }}">
                        </div>
                    </div>
                    
                    <div class="lg:w-4/12 w-full">
                        <div class="form-field">
                            <label for="email" class="text-xs uppercase text-gray-400">Email</label>
                            <input type="text" name="email" id="email" class="form-input small-input w-full" placeholder="Filter by Email" value="{{ $email ?? '' }}">
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
            @if(isset($users) && count($users) > 0)
            @foreach ($users as $user)
            <div class="detail-box relative">
                {{-- <div class="absolute left-4 -top-3">
                    <span class="badge progress small-badge">{{"Active"}}</span>
                </div> --}}
                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">user ID</span>
                            <span class="value">{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }} </span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">name</span>
                            <span class="value">{{$user->first_name . " " . $user->last_name}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">email</span>
                            <span class="value">{{$user->email}}</span>
                        </div>
                    </div>
                </div>

                {{-- <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">phone number</span>
                            <span class="value">{{$user->phone_number}}</span>
                        </div>
                    </div>
                </div> --}}

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Role</span>
                            <span class="value">{{isset($user->position) ? $user->position : '-'}}</span>
                        </div>
                    </div>
                </div>

                {{-- <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">company name</span>
                            <span class="value">{{ $user->company_name }}</span>
                        </div>
                    </div>
                </div> --}}

                <div class="w-2/12">
                    <div class="flex justify-end items-center h-full">

                        <button id="dropdownUserButton{{$user->id}}" data-dropdown-toggle="dropdownUser{{$user->id}}" class="inline-flex justify-center items-center gap-x-1 rounded-md px-3 py-2 text-sm text-white primary-bg" type="button">
                            View More
                            <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownUser{{$user->id}}" class="hidden z-10  bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownUserButton{{$user->id}}">
                                <li>
                                    <a href="{{route('superadmin.user.edit', ['userID' => $user->id])}}" class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                        <span>Edit</span>
                                    </a>
                                </li>
                                <li>
                                    {{-- <a href="{{route('superadmin.user.delete', ['userID' => $user->id])}}" class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                        <span>Delete</span>
                                    </a> --}}
                                    <form action="{{route('superadmin.user.delete', ["userID" =>$user->id])}}" method="post">
                                        @csrf
                                        <input type="hidden" name="_method" value="POST">
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
                <p class="text-sm text-gray-500">No users found</p>
            </div>
            @endif

        </div>

        <footer>
            <p class="number">Showing <strong>{{ $users->firstItem() }} - {{ $users->lastItem() }}</strong></p>
            {{ $users->links() }}

        </footer>
    </div>
</section>

@endsection
