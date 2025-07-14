@extends('backend.master')
@section('content')

@section('site-title')
Admin | Update Product
@endsection
@section('page-main-title')
Update Product
@endsection

<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-12">
            <!-- File input -->
            <form action="/admin/update-product-submit" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card p-3">
                    @if (Session::has('message'))
                    <p class="text-danger text-center">{{ Session::get('message') }}</p>
                    @endif
                    <div class="card-body">

                        <div class="row">
                            <div class="mb-3 col-6">
                                <input type="hidden" name="id" value="{{ $product[0]->id }}">
                                <label for="formFile" class="form-label">Name</label>
                                <input class="form-control" value="{{ $product[0]->name }}" type="text" name="name" />
                            </div>
                            <div class="mb-3 col-6">
                                <label for="formFile" class="form-label">Quantity</label>
                                <input class="form-control" value="{{ $product[0]->quantity }}" type="text" name="qty" />
                            </div>
                            <div class="mb-3 col-6">
                                <label for="formFile" class="form-label">Regular Price</label>
                                <input class="form-control" value="{{ $product[0]->regular_price }}" type="number"
                                    name="regular_price" />
                            </div>
                            <div class="mb-3 col-6">
                                <label for="formFile" class="form-label">Sale Price</label>
                                <input class="form-control" value="{{ $product[0]->sale_price }}" type="number" name="sale_price" />
                            </div>
                            <div class="mb-3 col-6">
                                <label for="formFile" class="form-label">Available Size</label>
                                <select name="size[]" class="form-control size-color" multiple="multiple">
                                    @foreach($attrSize as $value)
                                    @if(in_array($value->value, explode(',', $product[0]->attribute_size)))
                                    <option value="{{$value->value}}" selected>{{$value->value}}</option>
                                    @else <option value="{{$value->value}}">{{$value->value}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="formFile" class="form-label">Available Color</label>
                                <select name="color[]" class="form-control size-color" multiple="multiple">
                                    @foreach($attrColor as $value)
                                    @if(in_array($value->value, explode(',', $product[0]->attribute_color)))
                                    <option value="{{$value->value}}" selected>{{$value->value}}</option>
                                    @else <option value="{{$value->value}}">{{$value->value}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="formFile" class="form-label">Category</label>
                                <select name="category" class="form-control">
                                    @foreach($category as $value)
                                    @if($value->id == $product[0]->category_id)
                                    <option value="{{$value->id}}" selected>{{$value->name}}</option>
                                    @else <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="formFile" class="form-label text-danger">Recommend image size..x..pixels.</label>
                                <input class="form-control" type="file" name="thumbnail" />
                                <input class="form-control" type="hidden" name="old_thumbnail" value="{{ $product[0]->thumbnail }}">
                                <label for="formFile" class="form-label text-danger">Old Thumbnail</label><br>
                                <img src="/uploads/{{ $product[0]->thumbnail }}" alt="thumbnail" width="100px;">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="formFile" class="form-label text-danger">Description</label>
                                <textarea name="description" class="form-control" cols="30" rows="10">{{ $product[0]->description }}</textarea>
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