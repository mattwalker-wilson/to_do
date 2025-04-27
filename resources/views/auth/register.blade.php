@extends('layout')

@section('title', 'Register')

@section('content')

    <div>
        <h1 class="mb-4 text-center">Register</h1>

        <div class="justify-content-center">
            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input id="name" type="text" class="form-control" name="name" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" class="form-control" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Register</button>
            </form>

            <p class="mt-3">Already have an account? <a href="{{ route('login') }}">Log in here</a>.</p>
        </div>
    </div>

@endsection
