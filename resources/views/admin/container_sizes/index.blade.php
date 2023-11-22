@extends('layouts.admin')

@section('content')
    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <div class="w-6/12">
                    <h2 class="title">
                        Container Sizes
                    </h2>
                </div>

                <div class="w-6/12 justify-end flex">
                    <a href="{{route('superadmin.container-sizes.create')}}" class="default-button-v2">
                        <span>Add Container Size</span>
                    </a>
                </div>
            </header>

            <div class="detail-body mt-10">
                @if(isset($container_sizes) && count($container_sizes) > 0)
                    @foreach ($container_sizes as $container_size)
                        <div class="detail-box relative">
                            <div class="w-1/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">ID</span>
                                        <span class="value">{{$container_size->id}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-3/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Display Label</span>
                                        <span class="value">{{$container_size->display_label ?? '-'}}</span>
                                    </div>
                                    <div>
                                        <span class="head">Hapag Container Code</span>
                                        <span class="value">{{$container_size->hapag_value ?? '-'}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-3/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Maersk Container Code</span>
                                        <span class="value">{{$container_size->value ?? '-'}}</span>
                                    </div>
                                    <div>
                                        <span class="head">CMA Container Code</span>
                                        <span class="value">{{$container_size->cma_value ?? '-'}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-3/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">MSC Container Code</span>
                                        <span class="value">{{$container_size->msc_value ?? '-'}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex justify-end items-start h-full">

                                    <button id="dropdownInvoiceButton"
                                            data-dropdown-toggle="dropdownInvoice-{{$container_size->id}}"
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
                                    <div id="dropdownInvoice-{{$container_size->id}}"
                                         class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownInvoiceButton">
                                            <li>
                                                <a href="{{route('superadmin.container-sizes.edit', ['containerSize' => $container_size->id])}}"
                                                   class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                                    <span>Edit</span>
                                                </a>
                                            </li>
                                            <li>
                                                <form
                                                    action="{{route('superadmin.container-sizes.destroy', ["containerSize" => $container_size->id])}}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="block px-4 py-2 hover:bg-red-600 hover:text-white w-full text-left"
                                                            type="submit">Delete
                                                    </button>
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
                        <p class="text-sm text-gray-500">No Container Sizes found</p>
                    </div>
                @endif
            </div>

            <footer>
                {{ $container_sizes->links() }}
            </footer>
        </div>
    </section>
@endsection
