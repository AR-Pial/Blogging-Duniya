@extends('base')

@section('content')
    <div class="container">
        <div class="text-center pt-4 pt-lg-5">
            <img  src="{{ asset('images/BloggingDuniya.png') }}" alt="Example Image">
        </div>

        <div class="row justify-content-center my-2 my-lg-4">

            <div class="col-lg-5 col-md-7 col-sm-9 bg-light px-5 py-3 rounded">
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
