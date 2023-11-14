@extends('base')

@section('content')
    <div class="container">
        <div class="my-2 my-lg-3">
            <h3 class="py-2">{{ $blog->title }}</h3>
            <div class="">
                <img class="my-1 my-lg-2 rounded col-12 col-md-9 col-lg-7" src="{{ asset('storage/' . $blog->image) }}" alt="No Image">
                <p class="py-2 pt-lg-3 custom-montserrat" style="white-space: pre-wrap;">{{ $blog->content }}</p>
            </div>
        </div>
        <div class="d-flex">
            @if($liked)
                <i id="like-unlike" class="fa-solid fa-thumbs-down text-primary fs-5  py-1 px-2 rounded" style="background-color: #d9f2eb !important;"></i>
            @else
                <i id="like-unlike" class="fa-solid fa-thumbs-up text-primary fs-5 bg-light py-1 px-2 rounded" style="background-color: #d9f2eb !important;"></i>
            @endif
            <span class="text-dark badge fs-6 ms-2" style="background-color: #d9f2eb;">Likes: {{ $blog->totalLikes() }}</span>
            <span class="ms-1 badge text-dark ms-auto" style="background-color: #d9f2eb;"><i class="fa-solid fa-share fa-rotate-180 fs-5 text-primary"></i></span>
        </div>

        <hr>
        <div class="mb-3 col-12 col-lg-6">
            <input type="hidden" id="blogID" value="{{ $blog->id }}">
            <label class="fw-bolder mb-1" for="comment" class="form-label">Comments ({{ $blog->totalComments() }})</label>
            <textarea class="form-control" id="comment" rows="3"></textarea>
            <button id="comment_btn" class="btn btn-primary btn-sm my-2">Submit</button>
        </div>
        <div id="comments_div" class="col-12 col-lg-6">

                @foreach($comments as $comment)
                    <div class="px-2 py-1 mb-2  text-align-center rounded " style="background-color: #d9f2eb;"  >
                        <div class="d-flex flex-row">
                            <a href="#">{{ $comment->user->name }}</a>
                            @if($comment->user_id ==  Auth::user()->id)
                                <span id="delete_comment" data-id="{{$comment->id}}"  class="clickable-span text-primary ms-auto">Delete</span>
                            @endif

                        </div>
                        <p>{{ $comment->content }}</p>
                    </div>
                @endforeach

        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('body').on('click','#like-unlike', function(e) {
                let blog_id = $("#blogID").val()

                let url = "{{ route('like_unlike') }}";
                var formData = new FormData();
                formData.append('blog_id', blog_id);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    type: 'POST',
                    url: url, // Replace with your Laravel route
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        console.log(response)
                        location.reload();
                    }
                })

            });

            $('body').on('click','#comment_btn', function(e) {
                    let blog_id = $("#blogID").val()
                    let comment = $("#comment").val()
                    let url = "{{ route('create_comment') }}";

                    var formData = new FormData();
                    formData.append('blog_id', blog_id);
                    formData.append('comment', comment);
                    formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    type: 'POST',
                    url: url, // Replace with your Laravel route
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        console.log(response)
                        location.reload();
                    }
                })
            });
            $('body').on('click','#delete_comment', function(e) {
                let id = $(this).attr('data-id');
                let url = "{{ route('delete_comment') }}";
                $.ajax({
                    type: "POST",
                    data: {'id': id,
                        '_token': "{{ csrf_token() }}"
                    },
                    url: url,
                    success: function (data) {
                        console.log(data)
                        location.reload();
                    }
                });

            })
        })
    </script>
@endsection
