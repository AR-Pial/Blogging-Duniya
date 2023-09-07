<nav class="navbar navbar-expand-lg navbar-light py-2">
    <div class="container-fluid row">
        <div class="home col-9 col-md-3">
            <a class="" href="/"><img class="bg-transparent"  src="{{ asset('images/BloggingDuniya.png') }}" alt="Example Image"></a>
        </div>

        <button class="navbar-toggler col-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse col-12 col-md-9" id="navbarNavDropdown">
            <ul class="navbar-nav w-100">
                @if (Session::has('user_id'))
                    <li class="nav-item ">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/create_blog">Create Blog</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/user_posts">My Blogs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user_timeline">Timeline</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="community">Community</a>
                    </li>

                    <li class="nav-item dropdown ms-lg-auto">
                        <a class="nav-link" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1.3em" viewBox="0 0 448 512">
                                <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/>
                            </svg>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end overflow-hidden" aria-labelledby="navbarDropdownMenuLink">

                            <li class=""><a class="dropdown-item m-0" href="profile">Profile</a></li>
                            <li class=""><a class="dropdown-item m-0" href="logout">Log out</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
