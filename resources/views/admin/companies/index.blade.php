@extends('layouts.admin')

@section('content')
<?php 


$companiesData = $companies->toArray();

$inProgressCompaniesCount = count(array_filter($companiesData['data'], function ($companies) {
    return $companies['status'] === 'IN-PROGRESS';
}));
$cancelledCompaniesCount = count(array_filter($companiesData['data'], function ($companies) {
    return $companies['status'] === 'CANCELLED';
}));
$onHoldCompaniesCount = count(array_filter($companiesData['data'], function ($companies) {
    return $companies['status'] === 'ON-HOLD';
}));
$completedCompaniesCount = count(array_filter($companiesData['data'], function ($companies) {
    return $companies['status'] === 'COMPLETED';
}));

?>

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-6/12">
                <h2 class="title">
                    Companies
                </h2>
            </div>
            
            <div class="w-6/12 md:justify-end flex">
                <a href="/superadmin/companies/create" class="default-button-v2">
                    <span>add VENDORS</span>
                </a>
            </div>
        </header>

        <section class="search-result mt-8 mb-12">

            <form class="default-form" action="{{ route('superadmin.company.index') }}" method="GET">

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
                            <label for="country" class="text-xs uppercase text-gray-400">COUNTRY</label>
                            <input type="text" name="country" id="country" class="form-input small-input w-full"
                                placeholder="Filter by COUNTRY" value="{{ $country ?? '' }}">
                        </div>
                    </div>

                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="status" class="text-xs uppercase text-gray-400">Status</label>
                            <select name="status" class="form-input small-input w-full">
                                <option value="">Select </option>
                                @php
                                    $companyStatuses = config('constants.COMPANY_STATUSES');
                                @endphp
                                @if ($companyStatuses && count($companyStatuses) > 0)
                                    @foreach ($companyStatuses as $companyStatus)
                                        <option <?php echo $status == $companyStatus['value'] ? 'selected' : '' ?> value="{{ $companyStatus['value'] }}">{{ $companyStatus['label'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="w-3/12">
                        <button type="submit" class="default-button-v2 outline-button">
                            <span>Search</span>
                        </button>
                    </div>

                </div>

            </form>
        </section>

        <div class="tabbing mt-8">
            <div class="mb-8 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                    data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 pb-2 rounded-t-lg" id="all-tab" data-tabs-target="#all"
                            type="button" role="tab" aria-controls="all" aria-selected="false">All</button>
                    </li>

                </ul>
            </div>
        </div>

        <div id="myTabContent">
            <div class="" id="all" role="tabpanel" aria-labelledby="all-tab">
                <div class="detail-body flex flex-col gap-6">
                    @if(isset($companies) && count($companies)> 0)
                    @foreach ($companies as $company)
                    <div class="detail-box relative flex lg:items-end items-start lg:flex-row flex-col lg:gap-6 gap-4">
                        <div class="absolute -top-4 left-4">
                            @if($company->status == config('constants.COMPANY_REGISTRATION_STATUS_APPROVED') )
                            <span class="badge success">
                                Approved
                            </span>
                            @endif
                            @if($company->status == config('constants.COMPANY_REGISTRATION_STATUS_PENDING') )
                            <span class="badge progress">
                                Pending
                            </span>
                            @endif
                            @if($company->status == config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT') )
                            <span class="badge cancel">
                                Re-submit
                            </span>
                            @endif
                        </div>

                        <div class="lg:w-2/12 w-full">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Company ID</span>
                                    <span class="value">{{ str_pad($company->id, 5, '0', STR_PAD_LEFT) }} </span>
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-3/12 w-full">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Name</span>
                                    <span class="value">{{$company->name}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-3/12 w-full">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Email</span>
                                    <span class="value">{{$company->email}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-2/12 w-full">
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="head">Country</span>
                                    <span class="value">{{ $company->country}}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="lg:w-2/12 w-full">
                            <div class="flex justify-end items-center h-full">
                                <div>
                                    <a href="{{route('superadmin.company.details', ['companyID' =>$company->id ])}}"
                                        class="default-button small-button red">view details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @else

                    <div class="p-4 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-500">No companies found</p>
                    </div>
                    @endif
                </div>
            </div>

            <footer>
                <p class="number">Showing <strong>{{ $companies->firstItem() }} - {{ $companies->lastItem() }}</strong>
                </p>
                {{ $companies->links() }}
                {{-- <p class="total">Total <strong>{{ $bookings->total() }}</strong></p> --}}
            </footer>

            {{-- <footer>
                <p class="number">Showing <strong>1 - 10</strong></p>
                <ul class="pagination">
                    <li class="active">
                        1
                    </li>
                    <li>
                        2
                    </li>
                    <li>
                        3
                    </li>
                </ul>
                <p class="total">Total <strong>200</strong></p>
            </footer> --}}
        </div>
    </div>
</section>
@endsection