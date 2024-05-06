@extends('base')

@section('content')

    <div class="row min-vh-100 w-100">
        <div class="col-12 col-md-9 text-center p-2 p-lg-3">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-posts" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Community Posts</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-join" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Join Community</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-myCommunity" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">My Communities</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-createCommunity" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Create Community</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-posts" role="tabpanel" aria-labelledby="pills-home-tab">Here is your Community Post</div>
                <div class="tab-pane fade" id="pills-join" role="tabpanel" aria-labelledby="pills-profile-tab">Join new Communities</div>
                <div class="tab-pane fade" id="pills-myCommunity" role="tabpanel" aria-labelledby="pills-contact-tab">My Community here</div>
                <div class="tab-pane fade" id="pills-createCommunity" role="tabpanel" aria-labelledby="pills-contact-tab">Create Community here</div>
            </div>
        </div>
        <div class="col-12 col-md-3 text-center bg-light">
            <div class="p-2">
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search Community" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <div class="text-start my-2">
                <h5>Your Communities</h5>
                <ul>
                    <li>Travellers of Bangladesh</li>
                </ul>
            </div>

        </div>
    </div>

@endsection

@section('script')
    <script>

    </script>
@endsection
