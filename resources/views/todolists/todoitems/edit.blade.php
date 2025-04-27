@extends('layout')

@section('title', 'Edit To Do Item')

@section('content')
        <h2 class="mb-4 text-center">Edit Item in "<strong>{{ $toDoList->name }}</strong>"</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('lists.items.update', [$toDoList, $toDoItem]) }}">
            @csrf
            @method('PUT')
            @include('todolists.todoitems._form', ['submitText' => 'Update Item'])
        </form>
@endsection
