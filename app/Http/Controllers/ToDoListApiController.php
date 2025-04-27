<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use App\Models\ToDoList;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ToDoListApiController extends Controller
{
    public function index(): JsonResponse
    {
//        $user = Auth::user();
        $user =   User::findOrFail(4);
        Log::info($user->id);
        log::info("user is " . $user->name);
        // $todolist = ToDoList::where('user_id', $user->id)->get();
        // return response()->json($todolist);

        // if ($user->id != $todolist->user_id) {
        //     return response()->json(['message' => 'Unauthorized.'], 401);
        // }

        $todoLists = ToDoList::where('user_id', $user->id)
        ->with('toDoItems')
        ->get();
        return response()->json($todoLists);
    }

    public function store(Request $request): JsonResponse
    {
//        $user = Auth::user();
        $user =   User::findOrFail(4);

        $data = $request->validate([
            'name' => 'required'
        ]);

        $data['user_id'] = $user->id;

        try {
            $todolist = ToDoList::create($data);
            return response()->json([
                'message' => 'To Do List created successfully',
                'todolist' => $todolist
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'To Do List creation failed ' . $e->getMessage()], 500);
        }
        return response()->json(['message' => 'Something went wrong with To Do List creation.' ], 500);
    }

    public function show(ToDoList $todolist): JsonResponse
    {
//        $user = Auth::user();
        $user =   User::findOrFail(4);
        if ($user->id != $todolist->user_id) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        // return response()->json($todolist->with('toDoItems')->find($todolist->id));
        // use Load for "lazy eager loading". More efficient.
        return response()->json($todolist->load('toDoItems'));
    }

    public function update(Request $request, ToDoList $todolist): JsonResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $todolist->update($request->all());
            return response()->json([
                'message' => 'To Do List Updated successfully',
                'todolist' => $todolist
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'To Do List Update failed ' . $e->getMessage()], 500);
        }
        return response()->json(['message' => 'Something went wrong with To Do List Update.' ], 500);

    }

    public function destroy(ToDoList $todolist): JsonResponse
    {
        try {
            $todolist->delete();
            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json(['message' => 'To Do List deletion failed', 'error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Something went wrong with To Do List deletion.' ], 500);
    }
}
