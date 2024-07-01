<form action="{{ route('create_community')  }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Community</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row w-100">
                    <div class="mb-2 col-12">
                        <label class="mb-1" for="name">Name</label>
                        <input class="form-control" type="text"  name="name" placeholder="Name Here..." aria-label="name">
                    </div>

                    <div class="mb-3 col-12 col-lg-6">
                        <label class="mb-1" for="short_title">Short Title</label>
                        <input class="form-control" type="text" name="short_title" placeholder="Short Title Here..." aria-label="short_title">
                    </div>
                    
                    <div class="mb-3 col-12 col-lg-6">
                        <label class="mb-1" for="type">Visibility</label>
                        <select class="form-select" name="type">
                          <option selected>Select Visibility Type</option>
                          <option value="public">Public</option>
                          <option value="private">Private</option>
                          <option value="closed">Closed</option>
                        </select>
                    </div>

                    <div class="mb-3 col-12">
                      <label for="formFile" class="form-label">Cover Image</label>
                      <input class="form-control" name="image" type="file" id="image">
                    </div>

                    <div class="mb-3 col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3 col-12">
                        <label for="terms_condition" class="form-label">Terms & Conditions</label>
                        <textarea class="form-control" name="terms_condition" id="terms_condition" rows="3"></textarea>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal -->

