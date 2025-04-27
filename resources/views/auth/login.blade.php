@extends('layout')

@section('title', 'Login')

@section('content')

    <div>
        <h1 class="mb-4 text-center">Login</h1>

        <div class="justify-content-center">
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" class="form-control" name="email" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <p class="mt-3">Don't have an account? <a href="{{ route('register') }}">Register here</a>.</p>
        </div>
    </div>


@endsection
