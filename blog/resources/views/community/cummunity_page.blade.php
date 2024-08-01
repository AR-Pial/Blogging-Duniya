@extends('base')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    @elseif(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container">
        <div>
            <h3 class="py-3 text-center">{{ $community->name }}</h3>
            <div class="text-center">
                <span class="text-muted"> {{ ucfirst($community->visibility) }} - ({{ $community->getTotalMembers() }} people)</span>
            </div>
        </div>
       
        <div class="h-100 col-12 col-md-9 text-center p-2 p-lg-3">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-posts-tab" data-bs-toggle="pill" data-bs-target="#pills-posts" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Posts</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-members-tab" data-bs-toggle="pill" data-bs-target="#pills-members" type="button" role="tab" aria-controls="pills-members" aria-selected="false">Members</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-details-tab" data-bs-toggle="pill" data-bs-target="#pills-myCommunity" type="button" role="tab" aria-controls="pills-details" aria-selected="false">Community Details</button>
                </li>
            </ul>
            <!-- Join a community -->
            <div class="tab-content text-start" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-posts" role="tabpanel" aria-labelledby="pills-posts-tab">
                    Posts here
                </div>
                <div class="tab-pane fade" id="pills-members" role="tabpanel" aria-labelledby="pills-members-tab">
                    Members list here
                </div>
                <div class="tab-pane fade" id="pills-myCommunity" role="tabpanel" aria-labelledby="pills-details-tab">
                    Community details here
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

        })
    </script>
@endsection
