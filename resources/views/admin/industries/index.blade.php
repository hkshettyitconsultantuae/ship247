@extends('layouts.admin')

@section('content')
<?php 
    $industriesData = $industries->toArray();
?>


<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-3/12">
                <h2 class="title">
                    Industries
                </h2>
            </div>
  
            <div class="w-3/12 flex justify-end">
                <a href="{{route('superadmin.industry.create')}}" class="default-button-v2">
                    <span>add Industry</span>
                </a>
            </div>

         
        </header>

        <div class="detail-body mt-10">
            @if(isset($industries) && count($industries)> 0)
            @foreach ($industries as $industry)
            <div class="detail-box">
                
                <div class="w-6/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Name</span>
                            <span class="value">{{$industry->name}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-6/12">
                    <div class="flex justify-end items-center h-full">
                        <form action="{{route('superadmin.industry.destroy', ["industry" =>$industry->id])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="default-button-v2 small-button outline-button" type="submit">
                                <span>Delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            @else

            <div class="p-4 rounded-lg bg-gray-50">
                <p class="text-sm text-gray-500">No industries found</p>
            </div>
            @endif
        </div>

        <footer>
            <p class="number">Showing <strong>{{ $industries->firstItem() }} - {{ $industries->lastItem() }}</strong></p>
            {{ $industries->links() }}
            {{-- <p class="total">Total <strong>{{ $bookings->total() }}</strong></p> --}}
        </footer>
        
    </div>
</section>
@endsection