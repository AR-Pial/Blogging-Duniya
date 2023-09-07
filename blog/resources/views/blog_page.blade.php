@extends('base')

@section('content')
    <div class="container">
        <div class="my-3 my-lg-4">

            <h3 class="py-2">{{ $blog->title }}</h3>
            <div class="">
                <img class="my-1 my-lg-2" src="{{ asset('storage/' . $blog->image) }}" alt="No Image" height="200px">
                <p class="py-1 py-lg-2 " style="white-space: pre-wrap;">{{ $blog->content }}</p>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>

    </script>
@endsection
