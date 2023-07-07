<?php

namespace App\Http\Controllers;

use \Exception;
use App\Models\ToDoList;
use App\Models\ToDoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ToDoList $todolist)
    {
        $todoItems = $todolist->toDoItems()->get();
        return response()->json($todoItems);

        // return response()->json($todolist->to_do_items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ToDoList $todolist)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'completed' => 'nullable|boolean',
        ]);
    
        $data['to_do_list_id'] = $todolist->id;

        try {
            ToDoItem::create($data);
            return response()->json(['message' => 'To Do Item created successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => 'To Do Item creation failed ' . $e->getMessage()], 500);       
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ToDoItem  $todoitem
     * @return \Illuminate\Http\Response
     */
    public function show(ToDoList $todolist, ToDoItem $todoitem)
    {
        // Check that the ToDoList belongs to the currently authenticated user
        if ($todolist->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        if ($todoitem->to_do_list_id !== $todolist->id) {
            return response()->json(['message' => 'ToDoItem not found in this ToDoList'], 404);
        }

        return response()->json($todoitem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ToDoItem  $todoitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ToDoItem $todoitem)
    {
        $request->validate([
            'title' => 'required',
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ToDoItem  $todoitem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToDoList $todolist)
    {
        try {
            $todolist->delete();
            return response()->json(['message' => 'To Do Item deleted successfully'], 204);
        } catch (Exception $e) {
            return response()->json(['message' => 'To Do List deletion failed', 'error' => $e->getMessage()], 500);       
        }
    
        return response()->json(['message' => 'Something went wrong with To Do List deletion.' ], 500);         
    }
    
}
