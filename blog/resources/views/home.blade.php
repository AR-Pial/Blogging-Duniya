@extends('base')

@section('content')
<main class="m-0 p-0">
    <div class="row m-0 min-vh-100 justify-content-center">
        <div class="blogs-section mb-4 p-2 col-12 col-md-10 order-last order-md-first">
            @php
                use Carbon\Carbon;
            @endphp
            <div id="home_blogs" class="blogs row justify-content-center px-1 px-lg-2">
                <div id="blogs_div" class="blogs row justify-content-center px-1 px-lg-2">
                    @foreach($blogs as $blog)
                        <div class="mx-2 my-2 col">
                            <div class="m-0 py-1 d-flex flex-column lh-1">
                                <a class="custom-montserrat m-0 p-0" href=""> <span class="p-0 m-0">{{ $blog->user->name }}</span> </a>
{{--                                 <span class="text-muted m-0 py-1 " style="font-size: smaller">{{ date('d-m-y', strtotime($blog->created_at)) }}</span>--}}
                                <span id="blog_posted_id" class="text-muted m-0 p-0">
                                    <?php
                                        $createdAt = Carbon::parse($blog->created_at);
                                        $currentTime = Carbon::now();
                                        $diffInSeconds = $createdAt->diffInSeconds($currentTime);
                                        $diffInMinutes = $createdAt->diffInMinutes($currentTime);
                                        $diffInHours = $createdAt->diffInHours($currentTime);
                                        $diffInDays = $createdAt->diffInDays($currentTime);
                                        $diffInMonths = $createdAt->diffInMonths($currentTime);
                                        $diffInYears = $createdAt->diffInYears($currentTime);
                                    ?>

                                    @if ($diffInYears > 0)
                                        {{ $diffInYears }} year{{ $diffInYears > 1 ? 's' : '' }} ago
                                    @elseif ($diffInMonths > 0)
                                        {{ $diffInMonths }} month{{ $diffInMonths > 1 ? 's' : '' }} ago
                                    @elseif ($diffInDays > 0)
                                        {{ $diffInDays }} day{{ $diffInDays > 1 ? 's' : '' }} ago
                                    @elseif ($diffInHours > 0)
                                        {{ $diffInHours }} hour{{ $diffInHours > 1 ? 's' : '' }} ago
                                    @elseif ($diffInMinutes > 0)
                                        {{ $diffInMinutes }} minute{{ $diffInMinutes > 1 ? 's' : '' }} ago
                                    @else
                                        {{ $diffInSeconds }} second{{ $diffInSeconds > 1 ? 's' : '' }} ago
                                    @endif
                                </span>
                            </div>
                            <div class="card  d-flex flex-column border border-light rounded " style="width: 18rem;">
                                <a  href="{{route('blog_page',$blog->id )}}" class="">
                                    <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top rounded" alt="No Image" height="180px">
                                    <div class="">
                                       <h6 class="card-text text-dark p-2" style="height: 50px;">{{ Str::limit($blog->title, 70, '...') }}</h6>
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
                <div id="paginate_div" class="my-3 col-12 d-flex justify-content-center"> <span class="">{{ $blogs->links() }}</span></div>

            </div>
        </div>

        <div class="py-2 col-12 col-md-2 bg-light  justify-content-center">
            <div class="col-9 col-md-12 mt-md-2 mx-auto">
                <label for="sort_by">Sort by</label>
                <select id="sort_by" class="form-select form-select-sm" aria-label="Default select example">
                    <option selected value="recent">Most Recent</option>
                    <option value="last_hour">Last 1 Hour</option>
                    <option value="Last_24">Last 24 hours</option>
                    <option value="last_week">Last Week</option>
                    <option value="last_month">Last Month</option>
                    <option value="last_year">Last Year</option>
                    <option value="most_liked">Most Liked</option>
                    <option value="most_commented">Most Commented</option>
                    <option value="oldest">Oldest</option>
                </select>
            </div>

            <div class="col-9 col-md-12 mt-1 mt-md-2 mx-auto">
                <label for="filter_by">Filter by</label>
                <select id="filter_by" class="form-select form-select-sm" aria-label="Default select example">
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
        $(document).ready(function() {
            $('#sort_by,#filter_by').change(function (){
                sort_value = $('#sort_by').val()
                filter_value = $('#filter_by').val()
                console.log("sort by : " + sort_value)
                console.log("filter by : " + filter_value)
                let url = "{{ route('sorted_home_blogs') }}";

                $.ajax({
                    type: "GET",
                    data: {
                        sorted_value: sort_value,
                        filter_value: filter_value
                    },
                    url: url,
                    success: function (data) {
                        console.log(data)
                        let blogs_div = $('#blogs_div')
                        let blogs = data.blogs
                        blogs_div.html("")

                        $.each(blogs, function (index, blog) {
                            let limitedTitle = blog.title.length > 70 ? blog.title.slice(0, 70) + '...' : blog.title;

                            let blogElement = '<div class="mx-2 my-2 col">'+
                                                '<div class="m-0 py-1 d-flex flex-column lh-1">'+
                                                    '<a class="custom-montserrat" href="">'+blog.user_name+'</a>'+
                                                    '<span id="blog_posted_id" class="text-muted m-0 p-0">' +blog.posted_at+ '</span>'+
                                                '</div>'+
                                                '<div class="card  d-flex flex-column border border-light rounded " style="width: 18rem;">'+
                                                    '<a  href="/blog-page/'+ blog.id +'" class="">'+
                                                        '<img src="'+ blog.image +'" class="card-img-top rounded" alt="No Image" height="180px">'+
                                                            '<div class="">'+
                                                                '<h6 class="card-text text-dark p-2" style="height: 50px;">' +limitedTitle+ '</h6>'+
                                                            '</div>'+
                                                    '</a>'+
                                                    '<div class="d-flex m-1">'+
                                                        '<span class="badge text-dark" style="background-color: #d9f2eb;"><i class="fa-solid fa-thumbs-up"></i> ' + blog.total_likes +'</span>'+
                                                        '<span class="ms-1 badge text-dark" style="background-color: #d9f2eb;"><i class="fa-solid fa-comment"></i> '+ blog.total_comments +'</span>'+
                                                        '<span class="ms-1 badge text-dark ms-auto" style="background-color: #d9f2eb;"><i class="fa-solid fa-share fa-rotate-180"></i></span>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'
                            blogs_div.append(blogElement);

                        });

                        // let paginate ='<div class="my-3 col-12 d-flex justify-content-center"> <span class="">'+data.pagination_links+'</span></div>'
                        $('#paginate_div').html('');
                        $('#paginate_div').html(data.pagination_links);
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                        console.log(xhr)
                    }

                })
            });

            $(document).on('click', '.pagination a', function (e)  {
                e.preventDefault();
                let page = ($(this).attr('href').split('page=')[1]);

                getBlog(page);

            });

            function getBlog(page) {
                console.log('BLogs page =' + page);
                sort_value = $('#sort_by').val()
                filter_value = $('#filter_by').val()

                $.ajax({
                    type: "GET",
                    data: {
                        sorted_value: sort_value,
                        filter_value: filter_value
                    },
                    url: "{{ route('sorted_home_blogs') }}?page=" + page,
                    success: function (data) {
                        console.log(data)
                        let blogs_div = $('#blogs_div')
                        let blogs = data.blogs
                        blogs_div.html("")

                        $.each(blogs, function (index, blog) {
                            let limitedTitle = blog.title.length > 72 ? blog.title.slice(0, 72) + '...' : blog.title;

                            let blogElement = '<div class="mx-2 my-2 col">'+
                                '<div class="m-0 py-1 d-flex flex-column lh-1">'+
                                '<a class="custom-montserrat" href="">'+blog.user_name+'</a>'+
                                '<span id="blog_posted_id" class="text-muted m-0 p-0">' +blog.posted_at+ '</span>'+
                                '</div>'+
                                '<div class="card  d-flex flex-column border border-light rounded " style="width: 18rem;">'+
                                '<a  href="/blog-page/'+ blog.id +'" class="">'+
                                '<img src="'+ blog.image +'" class="card-img-top rounded" alt="No Image" height="180px">'+
                                '<div class="">'+
                                '<h6 class="card-text text-dark p-2" style="height: 50px;">' +limitedTitle+ '</h6>'+
                                '</div>'+
                                '</a>'+
                                '<div class="d-flex m-1">'+
                                '<span class="badge text-dark" style="background-color: #d9f2eb;"><i class="fa-solid fa-thumbs-up"></i> ' + blog.total_likes +'</span>'+
                                '<span class="ms-1 badge text-dark" style="background-color: #d9f2eb;"><i class="fa-solid fa-comment"></i> '+ blog.total_comments +'</span>'+
                                '<span class="ms-1 badge text-dark ms-auto" style="background-color: #d9f2eb;"><i class="fa-solid fa-share fa-rotate-180"></i></span>'+
                                '</div>'+
                                '</div>'+
                                '</div>'
                            blogs_div.append(blogElement);

                        });

                        // let paginate ='<div class="my-3 col-12 d-flex justify-content-center"> <span class="">'+data.pagination_links+'</span></div>'
                        $('#paginate_div').html('');
                        $('#paginate_div').html(data.pagination_links);
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                        console.log(xhr)
                    }
                })
            }

            {{--$('#filter_by').change(function (){--}}
            {{--    sort_value = $('#sort_by').val()--}}
            {{--    filter_value = $('#filter_by').val()--}}
            {{--    console.log("sort by : " + sort_value)--}}
            {{--    console.log("filter by : " + filter_value)--}}
            {{--    let url = "{{ route('sorted_home_blogs') }}";--}}

            {{--    $.ajax({--}}
            {{--        type: "GET",--}}
            {{--        data: {--}}
            {{--            sorted_value: sort_value,--}}
            {{--            filter_value: filter_value--}}
            {{--        },--}}
            {{--        url: url,--}}
            {{--        success: function (data) {--}}
            {{--            console.log(data)--}}
            {{--            $('#home_blogs').html("")--}}
            {{--        }--}}

            {{--    })--}}
            {{--});--}}
        });
    </script>
@endsection
