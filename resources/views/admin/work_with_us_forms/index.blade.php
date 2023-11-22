@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-6/12">
                <h2 class="title">
                    Work with Us
                </h2>
            </div>
        </header>


        <section class="search-result mt-8 mb-12">
               
            <form class="default-form" action="{{ route('superadmin.work-with-us-forms.index') }}" method="GET">

                <div class="flex 3xl:items-end items-start 3xl:flex-row flex-col 3xl:gap-6 gap-4">
                    <div class="3xl:w-3/12 w-full">
                        <div class="form-field">
                            <label for="name" class="text-xs uppercase text-gray-400">Name</label>
                            <input type="text" name="name" id="name" class="form-input small-input w-full" placeholder="Name" value="{{ $name ?? '' }}">
                        </div>
                    </div>
            
                    <div class="3xl:w-3/12 w-full">
                        <div class="form-field">
                            <label for="email" class="text-xs uppercase text-gray-400">Email</label>
                            <input type="text" name="email" id="email" class="form-input small-input w-full" placeholder="Email" value="{{ $email ?? '' }}">
                        </div>
                    </div>

                    <div class="3xl:w-3/12 w-full">
                        <div class="form-field">
                            <label for="contact_number" class="text-xs uppercase text-gray-400">Contact Number</label>
                            <input type="text" name="contact_number" id="contact_number" class="form-input small-input w-full" placeholder="Contact Number" value="{{ $contact_number ?? '' }}">
                        </div>
                    </div>
                    
                    <div class="3xl:w-3/12 w-full">
                        <div class="form-field">
                            <label for="company_name" class="text-xs uppercase text-gray-400">Company Name</label>
                            <input type="text" name="company_name" id="company_name" class="form-input small-input w-full" placeholder="company name" value="{{ $company_name ?? '' }}">
                        </div>
                    </div>
                            
                    <div class="3xl:w-3/12 w-full">
                        <div class="form-field">
                            <label for="industry" class="text-xs uppercase text-gray-400">Industry</label>
                            <input type="text" name="industry" id="industry" class="form-input small-input w-full" placeholder="Industry" value="{{ $industry ?? '' }}">
                        </div>
                    </div>
                    
                    <div class="3xl:w-3/12 w-full">
                        <button type="submit" class="default-button-v2 outline-button">
                            <span>Search</span>
                        </button>
                    </div>
                
                </div>

            </form>
        </section>



        <div class="detail-body mt-10">
            @if(isset($work_with_us_forms) && count($work_with_us_forms) > 0)
            @foreach ($work_with_us_forms as $form)
            <div class="detail-box relative mb-8">
                <div class="absolute left-4 -top-4">
                    @if($form->status == config('constants.WORK_WITH_US_FORM_STATUS_ACCEPTED'))
                        <span class="badge completed small-badge">{{ 'Accepted' }}</span>
                    @elseif($form->status == config('constants.WORK_WITH_US_FORM_STATUS_REJECTED'))
                        <span class="badge cancel small-badge">{{ 'Rejected' }}</span>
                    @elseif($form->status == config('constants.WORK_WITH_US_FORM_STATUS_PENDING'))
                        <span class="badge progress small-badge">{{ 'Pending' }}</span>
                    @endif
                </div>

                <div class="xl:w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">First Name</span>
                            <span class="value">{{$form->first_name}}</span>
                        </div>
                        <div>
                            <span class="head">Last Name</span>
                            <span class="value">{{$form->last_name}}</span>
                        </div>
                    </div>
                </div>

                <div class="xl:w-3/12 lg:mt-0 mt-4">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Email</span>
                            <span class="value">{{ $form->email }}</span>
                        </div>

                        <div>
                            <span class="head">Phone Number</span>
                            <span class="value">{{ $form->phone_number }}</span>
                        </div>
                    </div>
                </div>

                <div class="xl:w-5/12 lg:mt-0 mt-4">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Company Name</span>
                            <span class="value">{{ $form->company_name }}</span>
                        </div>

                        <div>
                            <span class="head">Industry</span>
                            <span class="value">
                                <ul>
                                @foreach(explode(',', $form->industry) as $industry)
                                    <li>{{$industry}}</li>
                                @endforeach
                                </ul>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="xl:w-2/12 lg:mt-0 mt-4">
                    <div class="flex flex-col gap-4 justify-between h-full">
                        <div>
                            <span class="head">Created At</span>
                            <span class="value">{{$form->created_at->format('d/m/Y')}}</span>
                        </div>

                        <div>
                            <a href="{{route('superadmin.work-with-us-form-detail', ['workWithUsFormID' => $form->id ])}}"
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
            {{ $work_with_us_forms->links() }}
        </footer>
    </div>
</section>

@endsection
