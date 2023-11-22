@extends('layouts.admin')

@section('content')
    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <h2 class="title">
                    Edit Sea Pricing
                </h2>
                <div>
                    <a href="{{route('superadmin.sea-schedules.index')}}" class="default-button-v2 outline-button">
                        <span>Back</span>
                    </a>
                </div>
            </header>

            <div class="detail-body">
                <div class="md:w-6/12">
                    <form method="POST" action="{{ route('superadmin.sea-schedules.update',[$seaSchedule->id]) }}"
                          class="default-form">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-8 mt-6">
                            <div class="form-field">
                                <label for="container_size" class="form-label">Container</label>
                                <select id="container_size" name="container_size" required
                                        class="form-input small-input mt-2 w-full block">
                                    <option value="">Select Container</option>
                                    @foreach($container_sizes as $container_size)
                                        <option value="{{ $container_size->value }}"
                                                @if($seaSchedule->container_size == $container_size->value) selected @endif
                                        >{{$container_size->display_label}}</option>
                                    @endforeach
                                </select>
                                @error('container_size')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="origin_id" class="form-label">Origin Port</label>
                                @include('admin.partials._location-select2',
                                    [
                                        'name' => 'origin_id',
                                        'selected_option_value' => $seaSchedule->origin_id,
                                        'selected_option_text' => $seaSchedule->origin->fullname,
                                        'required' => true,
                                    ]
                                )
                                @error('origin_id')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="pickup_charges" class="form-label">Pickup Charges</label>
                                <input type="number" id="pickup_charges" name="pickup_charges"
                                       class="form-input small-input mt-2 w-full block" required
                                       value="{{ $seaSchedule->pickup_charges }}">
                                @error('pickup_charges')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="origin_charges" class="form-label">Origin Charges</label>
                                <input type="number" id="origin_charges" name="origin_charges"
                                       class="form-input small-input mt-2 w-full block" required
                                       value="{{ $seaSchedule->origin_charges }}">
                                @error('origin_charges')
                                <span>{{ $message }}</span>
                                @enderror

                                <label class="form-field checkbox-field mt-2">
                                    <input type="checkbox" name="origin_charges_included" id="origin_charges_included"
                                           value="1" class="form-checkbox"
                                           @if($seaSchedule->origin_charges_included === 1) checked @endif>
                                    <span class="text">Included</span>
                                </label>
                            </div>

                            <div class="form-field">
                                <label for="ocean_freight" class="form-label">Ocean Freight</label>
                                <input type="number" id="ocean_freight" name="ocean_freight" required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{ $seaSchedule->ocean_freight }}">
                                @error('ocean_freight')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="destination_id" class="form-label">Destination</label>
                                @include('admin.partials._location-select2',
                                    [
                                        'name' => 'destination_id',
                                        'selected_option_value' => $seaSchedule->destination_id,
                                        'selected_option_text' => $seaSchedule->destination->fullname,
                                        'required' => true,
                                    ]
                                )
                                @error('destination_id')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="destination_charges" class="form-label">Destination Charges</label>
                                <input type="number" id="destination_charges" name="destination_charges" required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{ $seaSchedule->destination_charges }}">
                                @error('destination_charges')
                                <span>{{ $message }}</span>
                                @enderror

                                <label class="form-field checkbox-field mt-2">
                                    <input type="checkbox" name="destination_charges_included" id="destination_charges_included"
                                           value="1" class="form-checkbox"
                                           @if($seaSchedule->destination_charges_included === 1) checked @endif>
                                    <span class="text">Included</span>
                                </label>
                            </div>

                            <div class="form-field">
                                <label for="delivery_charges" class="form-label">Delivery Charges</label>
                                <input type="number" id="delivery_charges" name="delivery_charges"
                                       class="form-input small-input mt-2 w-full block" required
                                       value="{{ $seaSchedule->delivery_charges }}">
                                @error('delivery_charges')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-8 mt-6">
                            <div class="form-field">
                                <label for="company_id" class="form-label">Company</label>
                                <select id="company_id" name="company_id" required
                                        class="form-input small-input mt-2 w-full block">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company_id => $company_name)
                                        <option value="{{ $company_id }}"
                                                @if($seaSchedule->company_id == $company_id) selected @endif
                                        >{{$company_name}}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @foreach($seaSchedule->details as $detail)
                            <div class="grid grid-cols-2 gap-8 mt-6">
                                <div class="form-field">
                                    <label for="etd" class="form-label">ETD</label>
                                    <input type="date" id="etd" name="etd" required
                                           class="form-input small-input mt-2 w-full block"
                                           value="{{ $detail->etd->format('Y-m-d') }}">
                                    @error('etd')
                                    <span>{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-field">
                                    <label for="eta" class="form-label">ETA</label>
                                    <input type="date" id="eta" name="eta" required
                                           class="form-input small-input mt-2 w-full block"
                                           value="{{ $detail->eta->format('Y-m-d') }}">
                                    @error('eta')
                                    <span>{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-field">
                                    <label for="tt" class="form-label">TT</label>
                                    <input type="number" id="tt" name="tt" required
                                           class="form-input small-input mt-2 w-full block"
                                           value="{{ $detail->tt }}">
                                    @error('tt')
                                    <span>{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-field">
                                    <label for="ft" class="form-label">FT</label>
                                    <input type="number" id="ft" name="ft" required
                                           class="form-input small-input mt-2 w-full block"
                                           value="{{ $detail->ft }}">
                                    @error('ft')
                                    <span>{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-field">
                                    <label for="valid_till" class="form-label">Valid Till</label>
                                    <input type="date" id="valid_till" name="valid_till" required
                                           class="form-input small-input mt-2 w-full block"
                                           value="{{ $detail->valid_till->format('Y-m-d') }}">
                                    @error('valid_till')
                                    <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

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
            @if($seaSchedule->origin_charges_included === 1)
            toggleOriginCharges(true);
            @endif

            $('#origin_charges_included').change(function () {
                toggleOriginCharges($(this).is(':checked'));
            })

            function toggleOriginCharges(originChargesIncluded = false) {
                if (originChargesIncluded) {
                    $('#origin_charges').prop('readonly', true).prop('disabled', true).val(0);
                } else {
                    $('#origin_charges').prop('readonly', false).prop('disabled', false);
                }
            }

            @if($seaSchedule->destination_charges_included === 1)
            toggleDestinationCharges(true);
            @endif

            $('#destination_charges_included').change(function () {
                toggleDestinationCharges($(this).is(':checked'));
            })

            function toggleDestinationCharges(destinationChargesIncluded = false) {
                if (destinationChargesIncluded) {
                    $('#destination_charges').prop('readonly', true).prop('disabled', true).val(0);
                } else {
                    $('#destination_charges').prop('readonly', false).prop('disabled', false);
                }
            }
        });
    </script>
@endsection
