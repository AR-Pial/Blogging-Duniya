@extends('base')

@section('style')
    <style>
        /* Your custom CSS rules here */
        .min-vh-80 {
           height: 80vh !important;
        }
        /* Add more custom styles as needed */
    </style>
@endsection

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

    <div class="row min-vh-100 w-100">
        <div class="h-100 col-12 col-md-9 text-center p-2 p-lg-3">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-posts" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Community Posts</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-join" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Join Community</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-myCommunity" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Your Communities</button>
                </li>
            </ul>
            <!-- Join a community -->
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-posts" role="tabpanel" aria-labelledby="pills-home-tab">Here is your Community Post</div>
                <div class="tab-pane fade" id="pills-join" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="row justify-content-start my-2 mx-2 mx-lg-3 min-vh-80">
                        <div class="p-2 col-7 border-end border-1  border-secondary">
                            <form class="d-flex">
                                <input class="form-control me-2" type="search" placeholder="Search Community" aria-label="Search">
                                <button class="btn btn-outline-success my-0" type="button">Search</button>
                            </form>
                            <div class="my-2 my-lg-4 text-start">
                                <h5 class="">Suggested For You</h5>
                                <ul class="pe-2">
                                    @foreach($unowned_communities as $community)
                                        <li class="">
                                            <div class="d-flex justify-content-between">
                                                <a class="fs-5" href="{{route('community_page',$community->id )}}">
                                                    {{ $community->name }} <span class="text-muted fs-6">({{ $community->getTotalMembers() }} people)</span> 
                                                </a>
                                                <form action="{{ route('community_join', $community->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="fd-6 btn btn-sm btn-primary text-white">Join</button>
                                                </form>
                                            </div>
                                            
                                            <p>                               
                                                @foreach($community->categories as $category)
                                                    <span class="badge rounded-pill text-bg-info">{{ $category->name }}</span>
                                                @endforeach                                  
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                        <div class="col-5 text-start p-2 d-flex flex-column">
                            <div>
                                <h5 class="">Most Popular-100</h5>
                                <ul class="">
                                    @foreach($most_membered_communities as $community)
                                        <li class="">
                                            <div class="d-flex justify-content-between">
                                                <a class="fs-5" href="{{route('community_page',$community->id )}}">
                                                    {{ $community->name }} <span class="text-muted fs-6">({{ $community->getTotalMembers() }} people)</span>
                                                </a>
                                                <form action="{{ route('community_join', $community->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="fd-6 btn btn-sm btn-primary text-white">Join</button>
                                                </form>
                                            </div>
                                            
                                            <p>                               
                                                @foreach($community->categories as $category)
                                                    <span class="badge rounded-pill text-bg-info">{{ $category->name }}</span>
                                                @endforeach                                  
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div>
                                <h5 class="">Newest-100</h5>
                                <ul class="">
                                    @foreach($newest_communities as $community)
                                        <li class="">
                                            <div class="d-flex justify-content-between">
                                                <a class="fs-5" href="{{route('community_page',$community->id )}}">
                                                    {{ $community->name }} <span class="text-muted fs-6">({{ $community->getTotalMembers() }} people)</span>
                                                </a>
                                                <form action="{{ route('community_join', $community->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="fd-6 btn btn-sm btn-primary text-white">Join</button>
                                                </form>
                                            </div>
                                            
                                            <p>                               
                                                @foreach($community->categories as $category)
                                                    <span class="badge rounded-pill text-bg-info">{{ $category->name }}</span>
                                                @endforeach                                  
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="pills-myCommunity" role="tabpanel" aria-labelledby="pills-contact-tab">My Community here</div>
            </div>
        </div>

        <!-- right side bar -->
        <div class="col-12 col-md-3 bg-light min-h-100">
            <div>
                <button type="button" class="btn btn-sm btn-primary my-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Create Community</button>
            </div>
            @include('community.create_community_modal')
            <div class="text-start my-2">
                <div>
                    <h5>Your Communities</h5>
                    <ul>
                        @foreach($user_communities as $community)
                            <li>
                                <a href="{{route('community_page',$community->id )}}" class="fs-5">
                                    {{ $community->name }}
                                </a> <span class="text-muted fs-6">({{ $community->getTotalMembers() }} people)</span>
                                <p>                               
                                    @foreach($community->categories as $category)
                                        <span class="badge rounded-pill text-bg-info">{{ $category->name }}</span>
                                    @endforeach                                  
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h5>Already Joined</h5>
                    <ul>
                        @foreach($joined_communities as $community)
                            <li>
                                <a href="{{route('community_page',$community->id )}}" class="fs-5">
                                    {{ $community->name }}
                                </a> <span class="text-muted fs-6">({{ $community->getTotalMembers() }} people)</span>
                                <p>                               
                                    @foreach($community->categories as $category)
                                        <span class="badge rounded-pill text-bg-info">{{ $category->name }}</span>
                                    @endforeach                                  
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>

        </div>
    </div>

@endsection

@section('script')
    <script>

    </script>
@endsection
