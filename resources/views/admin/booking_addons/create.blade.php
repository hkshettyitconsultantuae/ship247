@extends('layouts.admin')

@section('content')
    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <h2 class="title">
                    Create {{ request()->route_type_name }} Booking Addons
                </h2>
                <div>
                    <a href="{{route('superadmin.'.request()->route_type_addition.'-booking-addons.index')}}" class="default-button-v2 outline-button">
                        <span>Back</span>
                    </a>
                </div>
            </header>

            <div class="detail-body">
                <div class="md:w-6/12">
                    <form method="post" action="{{route('superadmin.'.request()->route_type_addition.'-booking-addons.store')}}"
                          enctype="multipart/form-data" class="default-form">
                        @csrf

                        <div class="form-field mt-8">
                            <label for="name" class="form-label"> Name* </label>
                            <input type="text" name="name" value="{{old('name')}}" class="form-input w-9/12" required>
                        </div>

                        <div class="form-field mt-8">
                            <label for="additional_text" class="form-label"> Additional Text</label>
                            <input type="text" name="additional_text" value="{{old('additional_text')}}"
                                   class="form-input w-9/12">
                        </div>

                        <div class="form-field mt-8">
                            <label for="" class="form-label">Default Value</label>
                            <input type="number" name="default_value" value="{{old('default_value')}}"
                                   class="form-input w-9/12" required>
                        </div>

                        <div class="form-field mt-8">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" id="type" class="form-input w-9/12" required>
                                <option value="toggle">Toggle</option>
                                <option value="counter">Counter</option>
                            </select>
                        </div>

                        <div class="form-field mt-8 hidden" id="step_form_field">
                            <label for="step" class="form-label">Step</label>
                            <input type="number" name="step" min="1" value="{{old('step') ?? 1}}" class="form-input w-9/12">
                        </div>

                        <div class="form-field mt-8">
                            <label for="status">Status</label>
                            <label class="switch">
                                <input type="checkbox" name="status" value="{{STATUS_ENABLED}}" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <div class="form-field mt-8">
                            <button type="submit" class="default-button-v2">
                                <span>Save</span>
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
            $('#type').change(function () {
                const type = $(this).children("option:selected").text().toLowerCase().trim();
                toggleStepField(type);
            });

            function toggleStepField(type) {
                console.log(type)
                if (type === 'counter') {
                    $('#step_form_field').show();
                } else {
                    $('#step_form_field').hide();
                }
            }
        });
    </script>
@endsection

