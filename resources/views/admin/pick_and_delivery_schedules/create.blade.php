@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
	<div class="dashboard-detail-box">
		<header>
			<h2 class="title">
                CREATE PICK AND DELIVERY SCHEDULE
			</h2>
			<div>
				<a href="{{route('superadmin.pick-and-delivery-schedules.index')}}" class="default-button-v2 outline-button">
					<span>Back</span>
				</a>
			</div>
		</header>

		<div class="detail-body">
			<div class="md:w-6/12">
				<form method="POST" action="{{ route('superadmin.pick-and-delivery-schedules.store') }}" class="default-form">
					@csrf

                    <div class="grid grid-cols-2 gap-8 mt-6">
                        <div class="form-field">
                            <label for="origin_id" class="form-label">Origin</label>
                            @include('admin.partials._location-select2',
                                [
                                    'name' => 'origin_id',
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
                                            @if(old('container_size') == $container_size->value) selected @endif
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
                                   class="form-input small-input mt-2 w-full block" value="{{ old('price') }}">
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
                                            @if(old('company_id') == $company_id) selected @endif
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
                                    class="form-input small-input mt-2 w-full block" value="{{ old('valid_till') }}">
                            @error('valid_till')
                            <span>{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

					<div class="form-field mt-8">
						<button type="submit" class="default-button-v2">
							<span>Create</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@endsection
