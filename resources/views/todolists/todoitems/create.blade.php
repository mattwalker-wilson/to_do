@extends('layout')

@section('title', 'Create New To Do Item')

@section('content')
        <h2 class="mb-4 text-center">Add New Item to "<strong>{{ $toDoList->name }}</strong>"</h2>

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

        <form method="POST" action="{{ route('lists.items.store', $toDoList) }}">
            @include('todolists.todoitems._form', ['submitText' => 'Add Item'])
        </form>
@endsection
