<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ToDoList;
use App\Models\ToDoItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ToDoItemsApiController extends Controller
{
    public function index(ToDoList $todolist): JsonResponse
    {
        $todoItems = $todolist->toDoItems()->get();
        return response()->json($todoItems);
//         return response()->json($todolist->to_do_items);
    }

    public function store(Request $request, ToDoList $todolist): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'completed' => 'nullable|boolean',
        ]);

        $data['to_do_list_id'] = $todolist->id;

        try {
            ToDoItem::create($data);
            return response()->json(['message' => 'To Do Item created successfully'],201);
        } catch (Exception $e) {
            return response()->json(['message' => 'To Do Item creation failed ' . $e->getMessage()], 500);
        }
    }

    /**
     * Return a ToDoItem as JSON after verifying ownership and association.
     *
     * @param ToDoList $todolist
     * @param ToDoItem $todoitem
     * @return JsonResponse
     */
    public function show(ToDoList $todolist, ToDoItem $todoitem): JsonResponse
    {
        // Check that the ToDoList belongs to the currently authenticated user
        if ($todolist->user_id !== auth('api')->id()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($todoitem->to_do_list_id !== $todolist->id) {
            return response()->json(['message' => 'ToDoItem not found in this ToDoList'], 404);
        }

        return response()->json($todoitem);
    }

    public function update(Request $request, ToDoList $todolist, ToDoItem $todoitem): JsonResponse
    {

        if ($todolist->user_id !== auth('api')->id()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($todoitem->to_do_list_id !== $todolist->id) {
            return response()->json(['message' => 'ToDoItem not found in this ToDoList'], 404);
        }

        $request->validate([
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'completed' => 'nullable|boolean',
        ]);

        try {
            $todoitem->update($request->all());
                    return response()->json(['message' => 'To Do Item updated successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => 'To Do Item update failed' . $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, ToDoList $todolist, ToDoItem $todoitem): JsonResponse
    {
        if ($todolist->user_id !== auth('api')->id()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($todoitem->to_do_list_id !== $todolist->id) {
            return response()->json(['message' => 'ToDoItem not found in this ToDoList'], 404);
        }

        try {
            $todoitem->delete();
            return response()->json(['message' => 'To Do Item deleted successfully'], 204);
        } catch (Exception $e) {
            return response()->json(['message' => 'To Do List deletion failed', 'error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Something went wrong with To Do List deletion.' ], 500);
    }

}
