@extends('frontend.layout')
@section('title')
    Product Detail
@endsection
@section('content')
<main class="product-detail">

    <section class="review">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div class="thumbnail">
                        <img src="/uploads/{{ $product[0]->thumbnail }}" height="672px" alt="thumbnail">
                    </div>
                </div>
                
                <div class="col-7">
                    <div class="detail">
                        <div class="price-list">
                            @if($product[0]->sale_price > 0)
                                <div class="regular-price"><strike> US {{ $product[0]->regular_price }}</strike></div>
                                <div class="sale-price">US {{ $product[0]->sale_price }} </div>
                            @else
                                <div class="price ">US {{ $product[0]->regular_price }}</div>
                            @endif
                        </div>
                        <h5 class="title">{{ $product[0]->name }}</h5>
                        <div class="group-size">
                            <span class="title">Color Available</span>
                            <div class="group">
                                {{ $product[0]->attribute_color }}
                            </div>
                        </div>
                        <div class="group-size">
                            <span class="title">Size Available</span>
                            <div class="group">
                                {{ $product[0]->attribute_size }}
                            </div>
                        </div>
                        <div class="group-size">
                            <span class="title">Description</span>
                            <div class="description">
                                {{ $product[0]->description }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="main-title">
                        RELATED PRODUCTS
                    </h3>
                </div>
            </div>
            <div class="row">
                @foreach ($relatePro as $relate)
                    {{-- Check Product Promotion --}}
                    @if($relate->regular_price > 0)
                        @php
                            $statusRegularPrice = 'd-none';
                            $statusSalePrice    = '';
                        @endphp
                    @else 
                        @php    
                            $statusRegularPrice = '';
                            $statusSalePrice    = 'd-none';
                        @endphp 
                    @endif

                    {{-- Check Stock Available  --}}
                    @if($relate->quantity > 0)
                        @if($relate->sale_price > 0)
                            @php
                                $promoStatus     = '';
                                $label           = 'Promotion';          
                            @endphp
                        @else
                            @php
                                $promoStatus     = 'd-none';
                                $label           = '';
                            @endphp
                        @endif
                    @else
                        @php 
                            $promoStatus     = '';
                            $label           = 'Out Of Stock';
                        @endphp
                    @endif
    
                    <div class="col-3">
                        <figure>
                            <div class="thumbnail">
                                <div class="status {{ $promoStatus }}">
                                    {{ $label }}
                                </div>
                                <a href="/product/{{ $relate->slug }}">
                                    <img src="/uploads/{{$relate->thumbnail }}" alt="thumbnail">
                                </a>
                            </div>
                            <div class="detail">
                                <div class="price-list">
                                    <div class="price {{ $statusRegularPrice }}">US {{ $relate->regular_price }}</div>
                                    <div class="regular-price {{ $statusSalePrice }} "><strike> US {{ $relate->regular_price }}</strike></div>
                                    <div class="sale-price {{ $statusSalePrice }} ">US {{ $relate->sale_price }}</div>
                                </div>
                                <h5 class="title">{{ $relate->name }}</h5>
                            </div>
                        </figure>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</main>
@endsection