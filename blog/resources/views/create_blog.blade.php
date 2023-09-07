@extends('base')

@section('content')

    <h3 class="text-center py-3 mt-md-2">Create Blog</h3>

    <div class="col-12 col-md-9 col-lg-8 mx-auto bg-light rounded p-2 p-lg-5">
        <form action="create_blog" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 mx-auto">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" name="category" id="category" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3  mx-auto">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title Here" required>
            </div>
            <div class="mb-3   mx-auto">
                <label for="formFile" class="form-label">Image</label>
                <input class="form-control" type="file" name="image" id="image" placeholder="Image Here" required>
            </div>
            <div class="mb-3 mx-auto">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" name="blog_content" id="blog_content" rows="8" placeholder="Blog Content Here" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post</button>
        </form>
    </div>
@endsection

@section('script')
    <script>

    </script>
@endsection
