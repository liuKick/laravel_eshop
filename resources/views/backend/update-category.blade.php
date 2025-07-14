@extends('backend.master')
@section('content')

    @section('site-title')
        Admin | Update Category
    @endsection
    @section('page-main-title')
        Update Category
    @endsection

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-xl-12">
                <!-- File input -->
                <form action="/admin/update-category-submit" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card p-3">
                        @if (Session::has('message'))
                            <p class="text-danger text-center">{{ Session::get('message') }}</p>
                        @endif
                        <div class="card-body">
                         
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <input type="hidden" name="id" value="{{$id}}">
                                    <label for="formFile" class="form-label">Category</label>
                                    <input class="form-control" type="text" name="category" />
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
