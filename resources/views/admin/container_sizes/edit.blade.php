@extends('layouts.admin')

@section('content')
    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <h2 class="title">
                    Edit Container Size
                </h2>
                <div>
                    <a href="{{route('superadmin.container-sizes.index')}}" class="default-button-v2 outline-button">
                        <span>Back</span>
                    </a>
                </div>
            </header>


            <div class="detail-body">
                <div class="md:w-6/12">
                    <form method="POST" action="{{ route('superadmin.container-sizes.update', $containerSize->id) }}"
                          class="default-form">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-8 mt-6">
                            <div class="form-field">
                                <label for="display_label" class="form-label">Display Label</label>
                                <input type="text" id="display_label" name="display_label"
                                       class="form-input small-input mt-2 w-full block" value="{{ $containerSize->display_label }}">
                                @error('display_label')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-field">
                                <label for="value" class="form-label">Maersk Container Code</label>
                                <input type="text" id="value" name="value"
                                       class="form-input small-input mt-2 w-full block" value="{{ $containerSize->value }}">
                                @error('value')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-field">
                                <label for="value" class="form-label">CMA Container Code</label>
                                <input type="text" id="cma_value" name="cma_value"
                                       class="form-input small-input mt-2 w-full block" value="{{ $containerSize->cma_value }}">
                                @error('cma_value')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-field">
                                <label for="value" class="form-label">Hapag Container Code</label>
                                <input type="text" id="hapag_value" name="hapag_value"
                                       class="form-input small-input mt-2 w-full block" value="{{ $containerSize->hapag_value }}">
                                @error('hapag_value')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-field">
                                <label for="value" class="form-label">MSC Container Code</label>
                                <input type="text" id="msc_value" name="msc_value"
                                       class="form-input small-input mt-2 w-full block" value="{{ $containerSize->msc_value }}">
                                @error('msc_value')
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
