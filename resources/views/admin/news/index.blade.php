@extends('layouts.admin')

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-6/12">
                <h2 class="title">
                    News
                </h2>
            </div>

            <div class="md:w-6/12 md:justify-end flex">
                <a href="{{route('superadmin.news.create')}}" class="default-button-v2">
                    <span>Add News</span>
                </a>
            </div>
        </header>



        <section class="search-result mt-8 mb-12">

            <form class="default-form" action="{{ route('superadmin.news.index') }}" method="GET">

                <div class="flex lg:items-end items-start lg:flex-row flex-col lg:gap-6 gap-4">
                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="title" class="form-label-small">Title</label>
                            <input type="text" name="title" id="title" class="form-input small-input w-full"
                                placeholder="Filter by title" value="{{ $title ?? '' }}">
                        </div>
                    </div>
                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="category" class="form-label-small">Category</label>
                            <input type="text" name="category" id="category" class="form-input small-input w-full"
                            placeholder="Filter by category" value="{{ $category ?? '' }}">
                        </div>
                    </div>

                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="port" class="form-label-small">Published Date (mm/dd/yyyy)</label>
                            <input type="date" id="published_date" name="published_date"
                                class="form-input small-input w-full block" value="{{ isset($published_date) ?$published_date : '' }}">
                        </div>
                    </div>
                    
                    <div class="lg:w-3/12 w-full">
                        <button type="submit" class="default-button-v2 outline-button">
                            <span>Search</span>
                        </button>
                    </div>

                </div>

            </form>
        </section>


        <div class="detail-body mt-10">
            @if(isset($news_listing) && count($news_listing) > 0)
            @foreach ($news_listing as $news)
            <div class="detail-box relative lg:gap-0 gap-6 flex lg:flex-row flex-col">
                <div class="lg:w-6/12 w-full">
                    <div class="flex flex-col gap-6">
                        <div>
                            <span class="head">Title</span>
                            <span class="value">{{$news->title}}</span>
                        </div>
                        <div>
                            <span class="head">Category</span>
                            <span class="value">{{$news->category}}</span>
                        </div>
                    </div>
                </div>

                <div class="lg:w-2/12 w-full">
                    <div class="flex flex-col gap-6">
                        <div>
                            <span class="head">Published Date</span>
                            <span class="value">{{ $news->published_date->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>


                <div class="lg:w-2/12 w-full">
                    <div class="flex lg:justify-end items-start h-full">

                        <button id="dropdownInvoiceButton" data-dropdown-toggle="dropdownInvoice-{{$news->id}}"
                            class="inline-flex justify-center items-center gap-x-1 rounded-md px-3 py-2 text-sm text-white primary-bg"
                            type="button">
                            View More
                            <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownInvoice-{{$news->id}}"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownInvoiceButton">
                                <li>
                                    <a href="{{route('superadmin.news.edit', ['news' => $news->id])}}" class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                        <span>Edit</span>
                                    </a>
                                </li>
                                <li>
                                    <form action="{{route('superadmin.news.destroy', ["news" =>$news->id])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="w-full text-left px-4 py-2 hover:bg-red-600 hover:text-white" type="submit">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            @else

            <div class="p-4 rounded-lg bg-gray-50">
                <p class="text-sm text-gray-500">No news found</p>
            </div>
            @endif

        </div>

        <footer>
            {{ $news_listing->links() }}
        </footer>
    </div>
</section>

@endsection
