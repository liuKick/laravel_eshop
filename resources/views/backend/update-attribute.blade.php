@extends('backend.master')
@section('content')

    @section('site-title')
        Admin | Add Attribute
    @endsection
    @section('page-main-title')
        Add Attribute
    @endsection

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-xl-12">
                <!-- File input -->
                <form action="/admin/update-attribute-submit" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        @if (Session::has('message'))
                            <p class="text-danger text-center">{{ Session::get('message') }}</p>
                        @endif
                        <div class="card-body">

                            <div class="row">
                                <div class="mb-3 col-6">
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <label for="formFile" class="form-label">Type</label>
                                    <select name="type" class="form-control">
                                        <option value="size" {{ $attr[0]->type === 'size' ? 'selected':'' }} >Size</option>
                                        <option value="color"  {{ $attr[0]->type === 'color' ? 'selected':'' }} >Color</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Value</label>
                                    <input class="form-control" value="{{ $attr[0]->value }}" type="text"  name="value" />
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
