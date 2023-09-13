@extends('base')

@section('content')

    <div class="container">
        <h4 class="text-center pt-2 pt-lg-3">My Blogs</h4>
        <div class="blogs-section">
            <div class="blogs d-flex flex-wrap justify-content-center justify-content-lg-start">
                @foreach($blogs as $blog)
                    <div class="mx-2 mx-lg-4 my-2 my-lg-3 row">
                        <div class="col-12 card border-0 d-flex flex-column" style="width: 18rem;">
                            <div class="col-12">
                                <span id="edit" data-id="{{$blog->id}}" class="custom-montserrat clickable-span text-primary">Edit</span>
                                <span class="">-</span>
                                <span id="delete" data-id="{{$blog->id}}"  class="custom-montserrat clickable-span text-primary">Delete</span>
                            </div>
                            <div class="card  d-flex flex-column border border-light rounded" style="width: 18rem;">
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
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <div id="bs-modal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="edit_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="blog_id" id="blog_id" value="">
                        <div class="mb-3 mx-auto">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" name="category" id="category" required>
                            </select>
                        </div>
                        <div class="mb-3  mx-auto">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title Here" required>
                        </div>
                        <div class="mb-3   mx-auto">
                            <label for="formFile" class="form-label">Image</label>
                            <input class="form-control" type="file" name="image" id="image" placeholder="Image Here" required>
                            <div id="img_div" class="my-1 pt-1">

                            </div>
                        </div>
                        <div class="mb-3 mx-auto">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" name="blog_content" id="blog_content" rows="8" placeholder="Blog Content Here" required></textarea>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="submitButton" type="button"  class="btn btn-primary">Save changes</button>
                </div>

            </div>
        </div>
    </div>



@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('body').on('click','#delete', function(e) {
                let id = $(this).attr('data-id');
                let url = "{{ route('delete_blog') }}";
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
            });

            $('body').on('click','#edit', function(e) {

                $("#bs-modal").modal("show");
                let id = $(this).attr('data-id');
                let url = "{{ route('get_blog') }}";
                console.log("Id : ", id)
                $.ajax({
                    type: "GET",
                    data: {'id': id},
                    url: url,
                    success: function (data) {
                        console.log(data)
                        $("#title").val(data.blog.title)
                        $("#blog_id").val(data.blog.id)
                        $("#img_div").html('<img src=storage/'+ data.blog.image + ' height="75" width="90">')
                        $("#blog_content").val(data.blog.content)

                        var selectElement = $('#category');
                        selectElement.empty()
                        for(var i=0;i<data.categories.length;i++){
                            if(data.blog.category_id == data.categories[i].id){
                                selectElement.append('<option value="' + data.categories[i].id + '" selected>' + data.categories[i].name + '</option>');
                            }
                            else {
                                selectElement.append('<option value="' + data.categories[i].id + '">' + data.categories[i].name + '</option>');
                            }
                        }
                    }
                });
            });

            $("body").on('click','#submitButton',function() {
                var formData = new FormData();
                formData.append('blog_id', $("#blog_id").val());
                formData.append('category', $("#category").val());
                formData.append('title', $("#title").val());
                formData.append('blog_content', $("#blog_content").val());
                formData.append('image', $('#image')[0].files[0]);
                formData.append('_token', "{{ csrf_token() }}");
                let url = "{{ route('edit_blog') }}";

                console.log(url)

                $.ajax({
                    type: 'POST',
                    url: url, // Replace with your Laravel route
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        console.log(response)
                        $("#bs-modal").modal('hide');
                        location.reload();
                    }
                })
            });

            $("#image").change(function () {
                $("#img_div").html('');
                var files = this.files;
                for (var i = 0; i < files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#img_div").append('<img src="' + e.target.result + '" height="75" width="90">');
                    };
                    reader.readAsDataURL(files[i]);
                }
            });
        });
    </script>
@endsection
