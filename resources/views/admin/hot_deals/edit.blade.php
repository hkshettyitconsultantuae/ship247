@extends('layouts.admin')

@section('content')

    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <h2 class="title">
                    Edit {{ request()->route_type_name }} Hot Deals
                </h2>
                <div>
                    <a href="{{route('superadmin.'.request()->route_type_addition.'-hot-deals.index')}}" class="default-button-v2 outline-button">
                        <span>Back</span>
                    </a>
                </div>
            </header>
            <div class="detail-body">
                <div class="md:w-6/12">
                    <form method="POST" action="{{ route('superadmin.'.request()->route_type_addition.'-hot-deals.update', $hot_deal->id) }}"
                          class="default-form">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-8 mt-6">
                            <div class="form-field">
                                <label for="truck_type_id" class="form-label">Truck Type</label>
                                <select id="truck_type_id" name="truck_type_id" required
                                        class="form-input small-input mt-2 w-full block">
                                    <option value="">Select Truck Type</option>
                                    @foreach($truck_types as $id => $display_label)
                                        <option value="{{ $id }}"
                                                @if($hot_deal->truck_type_id == $id) selected @endif
                                        >{{$display_label}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-field hidden" id="container_size_form_field">
                                <label for="container_size" class="form-label">Container</label>
                                <select required id="container_size" name="container_size" required
                                        class="form-input small-input mt-2 w-full block">
                                    <option value="">Select Container</option>
                                    @foreach($container_sizes as $value => $display_label)
                                        <option value="{{ $value }}"
                                                @if($hot_deal->container_size == $value) selected @endif
                                        >{{$display_label}}</option>
                                    @endforeach
                                </select>
                                @error('container_size')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="axle" class="form-label">Select Axles</label>
                                <div class="form-field radio-field gap-8">
                                    <label class="switch">
                                        <input type="radio" name="axle" value="0" class="form-radio"
                                               @if($hot_deal->axle === 0) checked @endif>
                                        <span class="text">None</span>
                                    </label>

                                    <label class="switch">
                                        <input type="radio" name="axle" value="2" class="form-radio"
                                               @if($hot_deal->axle === 2) checked @endif>
                                        <span class="text"> 2 Axles </span>
                                    </label>

                                    <label class="switch">
                                        <input type="radio" name="axle" value="3" class="form-radio"
                                               @if($hot_deal->axle === 3) checked @endif>
                                        <span class="text"> 3 Axles </span>
                                    </label>

                                    <label class="switch">
                                        <input type="radio" name="axle" value="4" class="form-radio"
                                               @if($hot_deal->axle === 4) checked @endif>
                                        <span class="text"> 4 Axles </span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="max_load_in_ton" class="form-label">Max Load in ton</label>
                                <input type="number" id="max_load_in_ton" name="max_load_in_ton" required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{ $hot_deal->max_load_in_ton }}">
                            </div>

                            <div class="form-field">
                                <label for="origin_id" class="form-label">Pick Up Point</label>
                                @include('admin.partials._location-select2',
                                    [
                                        'name' => 'origin_id',
                                        'selected_option_value' => $hot_deal->origin_id,
                                        'selected_option_text' => $hot_deal->origin->fullname,
                                        'required' => true,
                                    ]
                                )
                                @error('origin_id')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="destination_id" class="form-label">Delivery Point</label>
                                @include('admin.partials._location-select2',
                                    [
                                        'name' => 'destination_id',
                                        'selected_option_value' => $hot_deal->destination_id,
                                        'selected_option_text' => $hot_deal->destination->fullname,
                                        'required' => true,
                                    ]
                                )
                                @error('destination_id')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="land_freight" class="form-label">Land Freight</label>
                                <input type="number" id="land_freight" name="land_freight" required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{ $hot_deal->land_freight }}">
                            </div>

                            <div class="form-field">
                                <label for="company_id" class="form-label">Company</label>
                                <select id="company_id" name="company_id" required
                                        class="form-input small-input mt-2 w-full block">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company_id => $company_name)
                                        <option value="{{ $company_id }}"
                                                @if($hot_deal->company_id == $company_id) selected @endif
                                        >{{$company_name}}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-field">
                                <label for="available_trucks" class="form-label">Available Trucks</label>
                                <input type="number" id="available_trucks" name="available_trucks" required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{ $hot_deal->available_trucks }}">
                            </div>

                            <div class="form-field">
                                <label for="tt" class="form-label">Transit Time (Days)</label>
                                <input type="number" id="tt" name="tt" required
                                       class="form-input small-input mt-2 w-full block" value="{{ $hot_deal->tt }}">
                            </div>

                            <div class="form-field">
                                <label for="detention_charges_per_hour" class="form-label">Detention Charges (Per
                                    Hrs)</label>
                                <input type="number" id="detention_charges_per_hour" name="detention_charges_per_hour"
                                       required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{$hot_deal->detention_charges_per_hour}}">
                            </div>

                            <div class="form-field">
                                <label for="valid_till" class="form-label">Validity</label>
                                <input type="date" id="valid_till" name="valid_till" required
                                class="form-input small-input mt-2 w-full block"
                                value="{{ \Carbon\Carbon::parse($hot_deal->valid_till)->toDateString() }}">
                            </div>
                        </div>
                        <div class="form-field mt-8">
                            <button type="submit" class="default-button-v2">
                                <span>Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- <div class="detail-body">
                <div class="md:w-6/12">
                    <form method="POST" action="{{ route('superadmin.'.request()->route_type_addition.'-hot-deals.update', $hot_deal->id) }}"
                          class="default-form">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-2 gap-8 mt-6">
                            <div class="form-field">
                                <label for="origin_id" class="form-label">Origin</label>
                                @include('admin.partials._location-select2',
                                    [
                                        'name' => 'origin_id',
                                        'selected_option_value' => $hot_deal->origin_id,
                                        'selected_option_text' => $hot_deal->origin->fullname,
                                        'required' => true,
                                    ]
                                )
                                @error('origin_id')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="destination_id" class="form-label">Destination</label>
                                @include('admin.partials._location-select2',
                                    [
                                        'name' => 'destination_id',
                                        'selected_option_value' => $hot_deal->destination_id,
                                        'selected_option_text' => $hot_deal->destination->fullname,
                                        'required' => true,
                                    ]
                                )
                                @error('destination_id')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="company_id" class="form-label">Company</label>
                                <select required id="company_id" name="company_id"
                                        class="form-input small-input mt-2 w-full block">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company_id => $company_name)
                                        <option value="{{ $company_id }}"
                                                @if($hot_deal->company_id == $company_id) selected @endif>{{$company_name}}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="container_size" class="form-label">Container</label>
                                <select required id="container_size" name="container_size"
                                        class="form-input small-input mt-2 w-full block">
                                    <option value="">Select Container</option>
                                    @foreach($containerSizes as $container_size_value =>$container_size_label)
                                        <option value="{{ $container_size_value }}"
                                                @if($hot_deal->container_size == $container_size_value) selected @endif>{{$container_size_label}}</option>
                                    @endforeach
                                </select>
                                @error('container_size')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="etd" class="form-label">ETD</label>
                                <input type="date" id="etd" name="etd" class="form-input small-input mt-2 w-full block"
                                       value="{{ $hot_deal->etd->format('Y-m-d') }}">
                                @error('etd')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="eta" class="form-label">ETA</label>
                                <input type="date" id="eta" name="eta" class="form-input small-input mt-2 w-full block"
                                       value="{{ $hot_deal->eta->format('Y-m-d') }}">
                                @error('eta')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="form-field">
                                <label for="tt" class="form-label">TT</label>
                                <input type="number" id="tt" name="tt" class="form-input small-input mt-2 w-full block" value="{{ $hot_deal->tt }}">
                                @error('tt')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="ft" class="form-label">FT</label>
                                <input type="number" id="ft" name="ft" class="form-input small-input mt-2 w-full block" value="{{ $hot_deal->ft }}">
                                @error('ft')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" id="start_date" name="start_date"
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{ $hot_deal->start_date->format('Y-m-d') }}">
                                @error('start_date')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" id="end_date" name="end_date"
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{ $hot_deal->end_date->format('Y-m-d') }}">
                                @error('end_date')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" id="amount" name="amount"
                                       class="form-input small-input mt-2 w-full block" value="{{ $hot_deal->amount}}">
                                @error('amount')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-field mt-8">
                            <button type="submit" class="default-button-v2">
                                <span>Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div> --}}
        </div>
    </section>
@endsection

@section('footer-scripts')
    <script>
        $(document).ready(function () {
            toggleContainerSize($('#truck_type_id').children("option:selected").text().toLowerCase());

            $('#truck_type_id').change(function () {
                const truckTypeLabel = $(this).children("option:selected").text().toLowerCase();
                toggleContainerSize(truckTypeLabel);
            });

            function toggleContainerSize(truckTypeLabel) {
                if (truckTypeLabel === 'container') {
                    $('#container_size_form_field').show();
                    $('#container_size_form_field select').prop('required', true);
                } else {
                    $('#container_size_form_field').hide();
                    $('#container_size_form_field select').prop('required', false);
                }
            }
        });
    </script>
@endsection
