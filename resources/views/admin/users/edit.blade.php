@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <h2 class="title">
                Edit User
            </h2>
            <div>
                <a href="{{route('superadmin.user.index')}}" class="default-button-v2 outline-button">
                    <span>Back</span>
                </a>
            </div>
        </header>


        <div class="detail-body">
            <div class="md:w-6/12">
                <form method="POST" action="{{ route('superadmin.user.update') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}" />
                    <div class="form-field mt-8">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-input w-full" value="{{ $user->first_name}}" required
                            autofocus>
                        @error('first_name')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field mt-8">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-input w-full" value="{{ $user->last_name}}" required>
                        @error('last_name')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field mt-8">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input w-full" value="{{ $user->email}}" required>
                        @error('email')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field mt-8">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="tel" id="phone_number" name="phone_number" class="form-input w-full" value="{{ $user->phone_number}}" required>
                        @error('phone_number')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field mt-8">
						<label for="position" class="form-label">Position</label>
						<select name="position" id="position" class="form-input w-full" required>
							<option value="">Select Position</option>
                            @if (
                                config('constants.EMPLOYEE_POSITIONS') &&
                                count(config('constants.EMPLOYEE_POSITIONS')) > 0 )
    
                                @foreach (config('constants.EMPLOYEE_POSITIONS') as $employeePosition)
                                    <option <?php echo $employeePosition->value == $user->position ? 'selected' : '' ?> value="{{$employeePosition->value}}">{{$employeePosition->label}}</option>
                                @endforeach
                                @endif
						</select>
					</div>

                    {{-- <div class="form-field mt-8">
                        <label for="company_name">Company</label>
                        <input type="text" id="company_name" name="company_name" value="{{ $user->company_name}}" required>
                        @error('company_name')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field mt-8">
                        <label for="industry">industry</label>
                        <input type="text" id="industry" name="industry" value="{{ $user->industry}}" required>
                        @error('industry')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field mt-8">
                        <label for="contact_no">Country</label>
                        <select name="country" class="form-input" required>
                            @foreach ($countries as $country )
                            <option <?php echo $country->name ==$user->country ? 'selected' : '' ?> value="{{$country->name}}">{{$country->name}}</option>
                            @endforeach

                        </select>
                        @error('country')
                        <span>{{ $message }}</span>
                        @enderror
                    </div> --}}

                    <div class="form-field mt-8">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password"  class="form-input w-full">
                        @error('password')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field mt-8">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input w-full">
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