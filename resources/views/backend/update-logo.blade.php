@extends('backend.master')
@section('content')

    @section('site-title')
        Admin | Update Logo
    @endsection
    @section('page-main-title')
       Update Logo
    @endsection

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-xl-12">
                <!-- File input -->
                <form action="/admin/update-logo-submit" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $logo->id }}">
                    <input type="hidden" name="old_thumbnail" value="{{ $logo->thumbnail }}" >
                   
                    <div class="card p-3"> 
                        <label for="">Old Logo</label>
                        <img src="/uploads/{{ $logo->thumbnail }}"  class="h-px-40 w-px-100" alt="">
                        @if (Session::has('message'))
                            <p class="text-danger text-center">{{ Session::get('message') }}</p>
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-12">
                                    <label for="formFile" class="form-label text-danger">Recommend image size ..x.. pixels</label>
                                    <input class="form-control" type="file" name="thumbnail" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" value="Add Logo">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    
@endsection
