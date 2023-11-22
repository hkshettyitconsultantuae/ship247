@extends('layouts.admin')

@section('content')

    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <div class="dashboard-counter">
                <div class="4xl:w-3/12 w-4/12">
                    <div class="count-box">
                        <h2 class="title">Current Bookings</h2>
        
                        <div class="flex items-end justify-between">
                            <p class="number">{{$data["in_progress_bookings"]}}</p>
                            <a href="#" class="default-button red">
                                <span>view all</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="4xl:w-3/12 w-4/12">
                    <div class="count-box">
                        <h2 class="title">total Bookings</h2>
        
                        <div class="flex items-end justify-between">
                            <p class="number">{{$data["total_bookings"]}}</p>
                            <a href="#" class="default-button red">
                                <span>view all</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="4xl:w-3/12 w-4/12">
                    <div class="count-box">
                        <h2 class="title">Bookings Onhold</h2>
        
                        <div class="flex items-end justify-between">
                            <p class="number">{{$data["on_hold_bookings"]}}</p>
                            <a href="#" class="default-button red">
                                <span>view all</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
