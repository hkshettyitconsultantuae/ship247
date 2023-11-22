@extends('layouts.admin')

@section('content')
    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <h2 class="title">
                    Edit Land Pricing
                </h2>
                <div>
                    <a href="{{route('superadmin.land-schedules.index')}}" class="default-button-v2 outline-button">
                        <span>Back</span>
                    </a>
                </div>
            </header>


            <div class="detail-body">
                <div class="md:w-6/12">
                    <form method="POST" action="{{ route('superadmin.land-schedules.update',[$landSchedule->id]) }}"
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
                                                @if($landSchedule->truck_type_id == $id) selected @endif
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
                                                @if($landSchedule->container_size == $value) selected @endif
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
                                               @if($landSchedule->axle === 0) checked @endif>
                                        <span class="text">None</span>
                                    </label>

                                    <label class="switch">
                                        <input type="radio" name="axle" value="2" class="form-radio"
                                               @if($landSchedule->axle === 2) checked @endif>
                                        <span class="text"> 2 Axles </span>
                                    </label>

                                    <label class="switch">
                                        <input type="radio" name="axle" value="3" class="form-radio"
                                               @if($landSchedule->axle === 3) checked @endif>
                                        <span class="text"> 3 Axles </span>
                                    </label>

                                    <label class="switch">
                                        <input type="radio" name="axle" value="4" class="form-radio"
                                               @if($landSchedule->axle === 4) checked @endif>
                                        <span class="text"> 4 Axles </span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="max_load_in_ton" class="form-label">Max Load in ton</label>
                                <input type="number" id="max_load_in_ton" name="max_load_in_ton" required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{ $landSchedule->max_load_in_ton }}">
                            </div>

                            <div class="form-field">
                                <label for="origin_id" class="form-label">Pick Up Point</label>
                                @include('admin.partials._location-select2',
                                    [
                                        'name' => 'origin_id',
                                        'selected_option_value' => $landSchedule->origin_id,
                                        'selected_option_text' => $landSchedule->origin->fullname,
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
                                        'selected_option_value' => $landSchedule->destination_id,
                                        'selected_option_text' => $landSchedule->destination->fullname,
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
                                       value="{{ $landSchedule->land_freight }}">
                            </div>

                            <div class="form-field">
                                <label for="company_id" class="form-label">Company</label>
                                <select id="company_id" name="company_id" required
                                        class="form-input small-input mt-2 w-full block">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company_id => $company_name)
                                        <option value="{{ $company_id }}"
                                                @if($landSchedule->company_id == $company_id) selected @endif
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
                                       value="{{ $landSchedule->available_trucks }}">
                            </div>

                            <div class="form-field">
                                <label for="tt" class="form-label">Transit Time (Days)</label>
                                <input type="number" id="tt" name="tt" required
                                       class="form-input small-input mt-2 w-full block" value="{{ $landSchedule->tt }}">
                            </div>

                            <div class="form-field">
                                <label for="detention_charges_per_hour" class="form-label">Detention Charges (Per
                                    Hrs)</label>
                                <input type="number" id="detention_charges_per_hour" name="detention_charges_per_hour"
                                       required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{$landSchedule->detention_charges_per_hour}}">
                            </div>

                            <div class="form-field">
                                <label for="valid_till" class="form-label">Validity</label>
                                <input type="date" id="valid_till" name="valid_till" required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{ $landSchedule->valid_till->toDateString() }}">
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
