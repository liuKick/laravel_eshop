@extends('frontend.layout')
@section('title')
    News Blog
@endsection
@section('content')
    <main class="shop news-blog">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="main-title">
                            NEWS BLOG
                        </h3>
                    </div>
                </div>
                <div class="row">
                    @foreach($news as $new)
                        <div class="col-3">
                            <figure>
                                <div class="thumbnail">
                                    <a href="/news-detail/{{ $new->id }}">
                                        <img src="/uploads/{{ $new->thumbnail }}" alt="htumbnail">
                                    </a>
                                </div>
                                <div class="detail">
                                    <h5 class="title">{{ substr($new->description,0, 160).'...' }}</h5>
                                </div>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection