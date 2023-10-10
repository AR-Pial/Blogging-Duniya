@extends('base')

@section('content')
<main class="m-0 p-0">
    <div class="row m-0">
    <div class="blogs-section mb-4 p-2 col-12 col-md-10 order-last order-md-first">
        <div class="blogs d-flex flex-wrap justify-content-center  justify-content-md-between px-1 px-lg-2">
            @foreach($blogs as $blog)
                <div class="mx-2 my-2">

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
    <div class="py-2 col-12 col-md-2 bg-light  justify-content-center">
        <div class="col-9 col-md-12 mt-md-2 mx-auto">
            <label for="sort_by">Sort by</label>
            <select id="sort_by" class="form-select form-select-sm" aria-label="Default select example">
                <option selected value="recent">Most Recent</option>
                <option value="last_hour">Last 1 Hour</option>
                <option value="today">Today</option>
                <option value="last_week">Last Week</option>
                <option value="last_month">Last Month</option>
                <option value="last_year">Last Year</option>
                <option value="most_liked">Most Liked</option>
                <option value="oldest">Oldest</option>
            </select>
        </div>

        <div class="col-9 col-md-12 mt-1 mt-md-2 mx-auto">
            <label for="sort_by">Filter by</label>
            <select id="sort_by" class="form-select form-select-sm" aria-label="Default select example">
                <option selected value="all">All</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

</main>
@endsection

@section('script')
    <script>

    </script>
@endsection
