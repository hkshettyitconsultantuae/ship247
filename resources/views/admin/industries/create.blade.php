@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <h2 class="title">
                Create Industry
            </h2>
            <div>
                <a href="" class="default-button-v2 outline-button">
                    <span>Back</span>
                </a>
            </div>
        </header>

        <div class="company-section">
            <div class="">
                <form method="POST" action="{{ route('superadmin.industry.store') }}" class="default-form" id="company-form">
                    @csrf
                    <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4 mt-14">
                        <p class="text-sm primary-font-medium primary-color uppercase">Industry information</p>
                    </div>
                    <input type="hidden" name="user_id" value="new_user"/>
                    <section class="w-8/12">
                        <div class="grid grid-cols-2 gap-8 mt-6">
                            <div class="form-field">
                                <label for="name" class="form-label">Name</label>
                                <input name="name" type="text" id="name" class="form-input small-input w-full" required>
                            </div>
        
                        </div>
                    </section>
        
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