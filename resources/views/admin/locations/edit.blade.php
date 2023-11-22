@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <h2 class="title">
                Edit Location
            </h2>
            <div>
                <a href="{{route('superadmin.locations.index')}}" class="default-button-v2 outline-button">
                    <span>Back</span>
                </a>
            </div>
        </header>


        <div class="detail-body">
            <div class="md:w-6/12">
                <form method="POST" action="{{ route('superadmin.locations.update', $location->id) }}" class="default-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="location_id" value="{{$location->id}}" />
                    <div  class="form-field mt-8">
                        <label for="country_id" class="form-label">Country</label>
                        <select required id="country_id" name="country_id" class="form-input">
							<option value="" >Select Country</option>
							@foreach($countries as $country_id => $country_name)
								<option value="{{ $country_id }}" @if($location->country_id == $country_id) selected @endif>{{$country_name}}</option>
							@endforeach
						</select>
                        @error('country_id')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div  class="form-field mt-8">
                        <label for="city" class="form-label">City</label>
                        <input type="text" id="city" name="city" class="form-input" value="{{ $location->city}}">
                        @error('city')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div  class="form-field mt-8">
                        <label for="port" class="form-label">Port</label>
                        <input type="text" id="port" name="port" class="form-input" value="{{ $location->port}}" required>
                        @error('port')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div  class="form-field mt-8">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" id="code" name="code" class="form-input" value="{{ $location->code}}" required>
                        @error('code')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div  class="form-field mt-8">
                        <label for="maersk_geo_id" class="form-label">Maersk Geo ID</label>
                        <input type="text" id="maersk_geo_id" name="maersk_geo_id" class="form-input" readonly value="{{ $location->maersk_geo_id}}">
                        @error('maersk_geo_id')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field mt-8">
                        <button type="submit" class="default-button-v2">
							<span>Update</span>
						</button>
                    </div>
                </form>
            </div>
</section>



@endsection