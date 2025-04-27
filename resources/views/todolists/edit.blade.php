@extends('layout')

@section('title', 'Edit ToDo List')

@section('content')
        <h2 class="mb-4 text-center">Edit ToDo List</h2>

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

        <form action="{{ route('lists.update', $toDoList) }}" method="POST">
            @csrf
            @method('PUT')
            @include('todolists._form', ['submitText' => 'Update List'])
        </form>
@endsection
