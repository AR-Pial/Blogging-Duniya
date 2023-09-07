@extends('base')

@section('content')
    <div class="container">
        <p class="pt-2 "> <span class="fs-4 custom-montserrat"> User Details </span> <a href="#">(Edit)</a></p>
        <div class="py-1">
            <p class="custom-montserrat"> <strong >Name:</strong> {{ $user['name'] }}</p>
            <p class="custom-montserrat"> <strong>Email:</strong> {{ $user['email'] }}</p>
            <p class="custom-montserrat"> <strong>Country:</strong> {{$user['country']  }}</p>
        </div>

    </div>

@endsection

@section('script')
    <script>

    </script>
@endsection
