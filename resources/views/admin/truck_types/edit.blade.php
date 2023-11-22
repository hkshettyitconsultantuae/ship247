@extends('layouts.admin')

@section('content')
    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <h2 class="title">
                    Edit Truck Type
                </h2>
                <div>
                    <a href="{{route('superadmin.truck-types.index')}}" class="default-button-v2 outline-button">
                        <span>Back</span>
                    </a>
                </div>
            </header>


            <div class="detail-body">
                <div class="md:w-6/12">
                    <form method="POST" action="{{ route('superadmin.truck-types.update', $truckType->id) }}"
                          class="default-form">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-8 mt-6">
                            <div class="form-field">
                                <label for="display_label" class="form-label">Display Label</label>
                                <input type="text" id="display_label" name="display_label"
                                       class="form-input small-input mt-2 w-full block" value="{{ $truckType->display_label }}">
                                @error('display_label')
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
