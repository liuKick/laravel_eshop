@extends('backend.master')
@section('content')

    @section('site-title')
        Admin | Update News
    @endsection
    @section('page-main-title')
        Add Update News
    @endsection

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-xl-12">
                <!-- File input -->
                <form action="/admin/update-news-submit" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card p-3">
                        @if (Session::has('message'))
                            <p class="text-danger text-center">{{ Session::get('message') }}</p>
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $news[0]->id }}">
                                <input type="hidden" name="old_thumbnail" value="{{ $news[0]->thumbnail }}">
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Title</label>
                                    <input class="form-control" type="text" name="title" value="{{ $news[0]->title }}" />
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Thumbnail</label>
                                    <input class="form-control" type="file" name="thumbnail" />
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Old Thumbnail</label><br>
                                    <img width="280px" src="/uploads/{{ $news[0]->thumbnail }}" alt="old thumbnail">
                                </div>
                                <div class="mb-3 col-12">
                                    <label for="formFile" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="" cols="30" rows="10">{{ $news[0]->description }}</textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" value="Add Post">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
