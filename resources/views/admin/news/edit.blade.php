@extends('layouts.admin')

@section('content')

    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <div class="md:w-6/12">
                    <h2 class="title">
                        Edit News
                    </h2>
                </div>

                <div class="md:w-6/12 md:justify-end flex">
                    <a href="{{route('superadmin.news.index')}}" class="default-button-v2 outline-button">
                        <span>Back</span>
                    </a>
                </div>
            </header>


            <div class="detail-body">
                <div class="md:w-6/12">
                    <form method="POST" action="{{ route('superadmin.news.update', $news->id) }}"
                          class="default-form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid">
                            <div class="form-field mt-8">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" id="title" name="title" class="form-input w-full" required min="3" value="{{ $news->title }}">
                                @error('title')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field mt-8">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" id="image" name="image" class="form-input w-full" accept="image/*">
                                @if($news->image)
                                    <img style="max-height: 100px; max-width: 100px;" src="{{ \Illuminate\Support\Facades\Storage::url($news->image) }}" />
                                @endif
                                @error('image')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field mt-8">
                                <label for="category" class="form-label">Category</label>
                                <input type="text" id="category" name="category" class="form-input w-full" value="{{ $news->category }}">
                                @error('category')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field mt-8">
                                <label for="detail" class="form-label">Detail</label>
                                <textarea id="tinymce-editor" name="detail" class="form-input w-full">{{ $news->detail }}</textarea>
                                @error('detail')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field mt-8">
                                <label for="published_date" class="form-label">Published Date</label>
                                <input type="date" id="published_date" name="published_date"
                                       class="form-input small-input mt-2 w-full block" value="{{ $news->published_date->format('Y-m-d') }}">
                                @error('published_date')
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
