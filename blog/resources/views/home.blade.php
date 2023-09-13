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
        <div class="blogs d-flex flex-wrap gap-5 justify-content-center">
            @foreach($blogs as $blog)
                <div class="">
                    <div class="m-0 p-0 d-flex">
                        <a class="custom-montserrat" href="">{{ $blog->user->name }}</a>
                    </div>

                    <div class="card  d-flex flex-column border border-light rounded " style="width: 18rem;">
                        <a  href="{{route('blog_page',$blog->id )}}" class="">
                            <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top rounded" alt="No Image" height="180px">
                            <div class="">
                               <h6 class="card-text text-dark p-2" style="height: 50px;">{{ Str::limit($blog->title, 73, '...') }}</h6>
                            </div>
                        </a>
                        <div class="d-flex m-1">
                            <span class="badge text-dark" style="background-color: #d9f2eb;"><i class="fa-solid fa-thumbs-up"></i> {{ $blog->totalLikes() }}</span>
                            <span class="ms-1 badge text-dark" style="background-color: #d9f2eb;"><i class="fa-solid fa-comment"></i> {{ $blog->totalComments() }}</span>
                            <span class="ms-1 badge text-dark ms-auto" style="background-color: #d9f2eb;"><i class="fa-solid fa-share fa-rotate-180"></i></span>
                        </div>
                    </div>
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
