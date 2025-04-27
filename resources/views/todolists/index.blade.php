@extends('layout')

@section('title', 'Your To Do Lists')

@section('content')
        <h1 class="mb-4 text-center">To Do Lists</h1>
        <a href="{{route('lists.create')}}" class="mb-2 d-inline-block"><button class="btn btn-primary">Create ToDo List</button></a>
        @if($todoLists->isEmpty())
            <p class="text-muted">You don't have any lists yet.</p>
        @else
            <ul class="list-group">
                @foreach($todoLists as $list)
                    <li class="list-group-item">
                        <strong><a href="{{ route('lists.edit', $list) }}" title="Edit">{{ $list->name }}</a></strong>

                        <form action="{{ route('lists.destroy', $list) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>

                        <ul class="mt-2">
                            @if($list->toDoItems->isNotEmpty())
                                @foreach($list->toDoItems as $item)
                                    <li>
                                        <strong><a href="{{ route('lists.items.edit', [$list, $item]) }}" title="Edit">{{ $item->title }}</a></strong> - {{ $item->description }}
                                        @if($item->completed)
                                            <span class="badge bg-success align-content-end">Done</span>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                            <li><a href="{{ route('lists.items.create', $list) }}"  class="btn btn-sm btn-outline-success">Add Item to this list</a></li>
                        </ul>
                    </li>
                @endforeach

            </ul>
        @endif
@endsection
