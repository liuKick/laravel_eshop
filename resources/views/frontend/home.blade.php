@extends('frontend.layout')
@section('title')
    Home
@endsection
@section('content')
    <main class="home">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="main-title">
                            NEW PRODUCTS
                        </h3>
                    </div>
                </div>
                <div class="row">
                    @foreach( $newProduct as $product)
                        {{-- Check Product Promotion  --}}
                        @if( $product->sale_price > 0)
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

                        {{-- Check stock available --}} 
                        @if($product->quantity > 0)
                            @if( $product->sale_price > 0)
                                @php 
                                    $promoStatus = '';
                                    $label       = 'Promontion';
                                @endphp
                            @else
                                @php 
                                    $promoStatus = 'd-none';
                                    $label       = '';
                                @endphp
                            @endif
                        @else
                            @php 
                                $promoStatus = '';
                                $label       = 'Out Of Stock';
                            @endphp
                        @endif
                        <div class="col-3">
                            <figure>
                                <div class="thumbnail">
                                    <div class="status {{ $promoStatus }}">
                                        {{ $label }}
                                    </div>
                                    <a href="/product/{{ $product->slug }}">
                                        <img src="/uploads/{{ $product->thumbnail }}" alt="thumbnail">
                                    </a>
                                </div>
                                <div class="detail">
                                    <div class="price-list">
                                        <div class="price {{ $statusRegularPrice }}">US {{ $product->regular_price }}</div>
                                        <div class="regular-price {{ $statusSalePrice }} "><strike> US {{ $product->regular_price }}</strike></div>   
                                        <div class="sale-price {{ $statusSalePrice }} ">US {{ $product->sale_price }}</div>
                                    </div>
                                    <h5 class="title">{{ $product->name }}</h5>
                                </div>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="main-title">
                            PROMOTION PRODUCTS
                        </h3>
                    </div>
                </div>
                <div class="row">
                    @foreach ($promoProduct as $promoProduct)
                        {{-- Check Product Promotion --}}
                        @if($promoProduct->sale_price > 0)
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

                        {{-- Check Stock avialable --}}
                        @if($promoProduct->quantity > 0)
                            @if($promoProduct->sale_price > 0)
                                @php
                                    $promoStatus = '';
                                    $label      = 'Promotion';
                                @endphp
                            @else
                                @php 
                                    $promoStatus = 'd-none';
                                    $label       = '';
                                @endphp                     
                            @endif
                        @else  
                            @php
                                $promoStatus = '';
                                $label       = 'Out Of Stock';
                            @endphp 
                        @endif
                        <div class="col-3">
                            <figure>
                                <div class="thumbnail">
                                     <div class="status {{ $promoStatus }}">
                                        {{ $label }}
                                    </div>
                                    <a href="/product/{{ $promoProduct->slug }}">
                                        <img src="/uploads/{{ $promoProduct->thumbnail }}" alt="thumbnail">
                                    </a>
                                </div>
                                <div class="detail">
                                    <div class="price-list">
                                    <div class="price {{ $statusRegularPrice }}">US {{ $product->regular_price }}</div>
                                        <div class="regular-price {{ $statusSalePrice }}"><strike> US {{ $promoProduct->regular_price}}</strike></div>
                                        <div class="sale-price  {{ $statusSalePrice }}"> US {{ $promoProduct->sale_price }}</div>
                                    </div>
                                    <h5 class="title">{{ $promoProduct->name }}</h5>
                                </div>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="main-title">
                            POPULAR PRODUCTS
                        </h3>
                    </div>
                </div>
                <div class="row">
                    @foreach ($popular_product as $pop) 
                        {{-- Check Product Promotion --}}
                        @if($pop->sale_price > 0)
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
                        
                        {{-- Check Stock available --}}
                        @if($pop->quantity > 0)
                            @if($pop->sale_price > 0)
                                @php 
                                    $promoStatus = '';
                                    $label       = 'Promotion'
                                @endphp
                            @else
                                @php
                                    $promoStatus = 'd-none';
                                    $label       = '';
                                @endphp
                            @endif    
                        @else
                            @php 
                                $promoStatus = '';
                                $label       = 'Out Of Stock';
                            @endphp
                        @endif
                        
                        <div class="col-3">
                            <figure>
                                <div class="thumbnail">
                                     <div class="status {{ $promoStatus }}">
                                        {{ $label }}
                                    </div>
                                    <a href="/product/{{ $pop->slug }}">
                                        <img src="/uploads/{{ $pop->thumbnail }}" alt="thumnail">
                                    </a>
                                </div>
                                <div class="detail">
                                    <div class="price-list">
                                        <div class="price {{ $statusRegularPrice }}">US {{ $pop->regular_price }}</div>
                                        <div class="regular-price {{ $statusSalePrice }}"><strike> US {{ $pop->regular_price }} </strike></div>
                                        <div class="sale-price {{ $statusSalePrice }}">US {{ $pop->sale_price }}</div>
                                    </div>
                                    <h5 class="title">{{ $pop->name }}</h5>
                                </div>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </main>  
@endsection
