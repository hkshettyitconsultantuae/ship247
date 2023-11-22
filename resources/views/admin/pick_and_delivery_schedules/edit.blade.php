@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <h2 class="title">
                Edit PICK AND DELIVERY SCHEDULE
            </h2>
            <div>
                <a href="{{route('superadmin.pick-and-delivery-schedules.index')}}" class="default-button-v2 outline-button">
                    <span>Back</span>
                </a>
            </div>
        </header>


        <div class="detail-body">
            <div class="md:w-6/12">
                <form method="POST" action="{{ route('superadmin.pick-and-delivery-schedules.update',[$pickAndDeliverySchedule->id]) }}" class="default-form">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-8 mt-6">
                        <div class="form-field">
                            <label for="origin_id" class="form-label">Origin</label>
                            @include('admin.partials._location-select2',
                                [
                                    'name' => 'origin_id',
                                    'selected_option_value' => $pickAndDeliverySchedule->origin_id,
                                    'selected_option_text' => $pickAndDeliverySchedule->origin->fullname,
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
                                    'selected_option_value' => $pickAndDeliverySchedule->destination_id,
                                    'selected_option_text' => $pickAndDeliverySchedule->destination->fullname,
                                    'required' => true,
                                ]
                            )
                            @error('destination_id')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="container_size" class="form-label">Container Size</label>
                            <select required id="container_size" name="container_size" required
                                    class="form-input small-input mt-2 w-full block">
                                <option value="">Select Container</option>
                                @foreach($container_sizes as $container_size)
                                    <option value="{{ $container_size->value }}"
                                            @if($pickAndDeliverySchedule->container_size == $container_size->value) selected @endif
                                    >{{$container_size->display_label}}</option>
                                @endforeach
                            </select>
                            @error('container_size')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" id="price" name="price" required
                                   class="form-input small-input mt-2 w-full block" value="{{ $pickAndDeliverySchedule->price }}">
                            @error('price')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="company_id" class="form-label">Company</label>
                            <select required id="company_id" name="company_id" required
                                    class="form-input small-input mt-2 w-full block">
                                <option value="" >Select Company</option>
                                @foreach($companies as $company_id => $company_name)
                                    <option value="{{ $company_id }}"
                                            @if($pickAndDeliverySchedule->company_id == $company_id) selected @endif
                                    >{{$company_name}}</option>
                                @endforeach
                            </select>
                            @error('company_id')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="valid_till" class="form-label">Valid Till</label>
                            <input type="date" id="valid_till" name="valid_till" required
                                   class="form-input small-input mt-2 w-full block"
                                   value="{{ $pickAndDeliverySchedule->valid_till->format('Y-m-d') }}">
                            @error('valid_till')
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
        </div>
    </div>
</section>
@endsection
