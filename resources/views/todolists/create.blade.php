@extends('layout')

@section('title', 'Create New To Do List')

@section('content')
        <h2 class="mb-4 text-center">Create ToDo List</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lists.store') }}" method="POST">
            @include('todolists._form', ['submitText' => 'Create List'])
        </form>
@endsection
