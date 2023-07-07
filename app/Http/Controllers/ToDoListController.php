<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ToDoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user(); 

        // if ($user->id != $todolist->user_id) {
        //     return response()->json(['message' => 'Unauthorized.'], 401);
        // }

        $todoLists = ToDoList::where('user_id', $user->id)
        ->with('toDoItems')
        ->get();
        return response()->json($todoLists);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ToDoList  $todolist
     * @return \Illuminate\Http\Response
     */
    public function show(ToDoList $todolist)
    {
        $user = Auth::user();
        if ($user->id != $todolist->user_id) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        // return response()->json($todolist->with('toDoItems')->find($todolist->id));
        // use Load for "lazy eager loading". More efficient.
        return response()->json($todolist->load('toDoItems'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\ToDoList $todolist
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ToDoList $todolist)
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ToDoList  $todolist
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToDoList $todolist)
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
