<?php

namespace App\Http\Controllers;

use App\Models\ToDoItems;
use Illuminate\Http\Request;

class ToDoItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todoItems = ToDoItems::all();

        return response()->json($todoItems);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'todo_list_id' => 'required',
        ]);
    
        ToDoItems::create($request->all());
    
        return response()->json(['message' => 'To Do Item created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ToDoItems  $todoItems
     * @return \Illuminate\Http\Response
     */
    public function show($todoItems)
    {
        return response()->json($todoItems);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ToDoItems  $todoItems
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ToDoItems $todoItems)
    {
        $request->validate([
            'name' => 'required',
            'completed' => 'required',
        ]);
    
        $todoItems->update($request->all());
    
        return response()->json(['message' => 'To Do Items updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ToDoItems  $todoItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToDoItems $todoItem)
    {
        $todoItem->delete();
    
        return response()->json(['message' => 'To Do Item deleted successfully']);
    }
}
