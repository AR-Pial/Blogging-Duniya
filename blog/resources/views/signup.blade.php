@extends('base')

@section('content')
    <div class="container">
        <div class="text-center pt-4 pt-lg-5">
            <img  src="{{ asset('images/BloggingDuniya.png') }}" alt="Example Image">
        </div>
        <div class="row justify-content-center my-2 my-lg-4">
            <div class="col-lg-6 col-md-7 col-sm-10 bg-light px-5 py-3 rounded">
                <form id="registrationForm" action="" method="post">
                    @csrf
                    <h3 class="text-center text-secondary mb-3">Sign up</h3>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Your Name">
                    </div>
                    <div id="name-error" class="alert alert-danger d-none" role="alert">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
                    </div>
                    <div id="email-error" class="alert alert-danger d-none" role="alert">
                    </div>
                    <div id="email-exists-error" class="alert alert-danger d-none" role="alert">
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        @include('countries')
                    </div>
                    <div id="country-error" class="alert alert-danger d-none" role="alert">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <div id="password-error" class="alert alert-danger d-none" role="alert">
                    </div>

                    <div class="mb-3">
                        <label for="password2" class="form-label">Confirm Password</label>
                        <input type="password" name="password2" class="form-control" id="password2" placeholder="Confirm Password">
                    </div>
                    <div id="password-matching-error" class="alert alert-danger d-none" role="alert">
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                <div class="my-2">
                    Already have an account? <a href="/" class="">Login</a>
                </div>
            </div>


        </div>

    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#registrationForm').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'register/',
                    type: 'POST',
                    data: $(this).serialize(),
                    beforeSend: function() {
                        // Clear previous error messages
                        $('#name-error').html('');
                        $('#name-error').addClass('d-none');

                        $('#email-error').html('');
                        $('#email-error').addClass('d-none');

                        $('#email-exists-error').html('');
                        $('#email-exists-error').addClass('d-none');

                        $('#country-error').html('');
                        $('#country-error').addClass('d-none');

                        $('#password-error').html('');
                        $('#password-error').addClass('d-none');

                        $('#password-matching-error').html('');
                        $('#password-matching-error').addClass('d-none');
                    },
                    success: function(response) {

                        swal(response.message, {
                            icon: "success",
                        }).then((value) => {
                            window.location.href = '/';
                        });
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Registration failed';
                        if (errorMessage === 'Name required') {
                            $('#name-error').removeClass("d-none")
                            $('#name-error').text(errorMessage);
                        }
                        if (errorMessage === 'Email required') {
                            $('#email-error').removeClass("d-none")
                            $('#email-error').text(errorMessage);
                        }

                        if (errorMessage === 'Email Exists') {
                            $('#email-exists-error').removeClass("d-none")
                            $('#email-exists-error').text(errorMessage);
                        }
                        if (errorMessage === 'Country required') {
                            $('#country-error').removeClass("d-none")
                            $('#country-error').text(errorMessage);
                        }


                        if (errorMessage === 'Password error') {
                            $('#password-error').removeClass("d-none")
                            $('#password-error').text("Password  must be at least 8 characters long and contain at least one number");
                        }

                        if(errorMessage === 'Passwords do not match'){
                            $('#password-matching-error').removeClass("d-none");
                            $('#password-matching-error').text(errorMessage);
                        }



                    }
                });
            })



        })

    </script>
@endsection
