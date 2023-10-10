@extends('base')

@section('content')
    <div class="banner m-0 min-vh-100 p-0">

        <div class="row align-items-center m-0">
{{--            <img src="{{ asset('images/Blog-banner.png') }}" alt="">--}}
            <div class="col-12 col-md-6 d-flex">
                <p class="custom-montserrat text-center fs-4  px-2 px-lg-5">Welcome to <span class="fs-3 text-danger">Blogging Duniya</span>,  Your Literary Haven - Where Ideas Take Flight and Imagination Knows No Bounds. </p>
            </div>
            <div class="col-12 col-md-6">
                <div class="row justify-content-center my-2 my-lg-5 mx-2">

                    <div class="col-12 col-lg-10  bg-light px-5 py-3 rounded">
                        <form id="loginForm" action="" method="post">
                            <h3 class="text-center text-secondary mb-3">Log In</h3>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
                            </div>
                            <div id="email-error" class="alert alert-danger d-none" role="alert">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                            </div>
                            <div id="password-error" class="alert alert-danger d-none" role="alert">
                            </div>
                            <button type="submit" class="btn btn-success">Log In</button>
                        </form>
                        <div class="my-2">
                            New here? <a href="register" class="">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>




@endsection

@section('script')
    <script>

        $(document).ready(function() {
            $('#loginForm').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'login-req',
                    type: 'GET',
                    data: $(this).serialize(),
                    beforeSend: function() {
                        // Clear previous error messages
                        $('#email-error').html('');
                        $('#email-error').addClass('d-none');

                        $('#password-error').html('');
                        $('#password-error').addClass('d-none');

                    },
                    success: function(response) {

                        console.log(response);
                        window.location.href = '/';
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Registration failed';
                        if (errorMessage === 'Invalid Email!') {
                            $('#email-error').removeClass("d-none")
                            $('#email-error').text(errorMessage);
                        }

                        if (errorMessage === 'Invalid Password!') {
                            $('#password-error').removeClass("d-none")
                            $('#password-error').text(errorMessage);
                        }
                    }
                })
            })
        })

    </script>
@endsection
