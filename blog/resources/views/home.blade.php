@extends('base')

@section('content')

<div class="banner row m-0">
    <div class="col-12 col-md-7 d-flex justify-content-center align-items-center">
        <p class="custom-montserrat fs-4  px-2 px-lg-5">Welcome to <span class="fs-3 text-danger">Blogging Duniya</span>,  Your Literary Haven - Where Ideas Take Flight and Imagination Knows No Bounds. </p>
    </div>

    <div class="col-12 col-md-5 banner-image text-center">
        <img src="{{ asset('images/Blog-banner.png') }}" alt="">
    </div>
</div>

<div class="container">
    <div class="blogs-section my-4">
        <div class="blogs d-flex flex-wrap gap-5">
            @foreach($blogs as $blog)
                <div><a class="custom-montserrat pb-1" href="">{{ $blog->user->name }}</a>
                    <a href="{{route('blog_page',$blog->id )}}" class="mx-2 mx-lg-4 my-2 my-lg-3">
                        <div class="card  d-flex flex-column border border-light rounded" style="width: 18rem;">
                            <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top rounded" alt="No Image" height="200px">
                            <div class="card-body">
                               <h5 class="card-text text-dark text-center" style="height: 66px;">{{ Str::limit($blog->title, 81, '...') }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</div>

@endsection

@section('script')
    <script>

    </script>
@endsection
