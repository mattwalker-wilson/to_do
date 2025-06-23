<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateToDoListRequest;
use App\Http\Requests\UpdateToDoListRequest;
use App\Services\ToDoListService;
use Exception;
use App\Models\ToDoList;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ToDoListWebController extends Controller
{
    /**
     *
     * @return View
     */
    public function index(): View
    {
        $todoLists  = collect();

        try {
            $todoLists = ToDoList::where('user_id', auth('web')->id())
                ->with('toDoItems')
                ->get();
        } catch (Exception $e) {
            return view('todolists.index', compact('todoLists'))->with('error', 'An error occurred: ' . $e->getMessage());
        } catch (QueryException $e) {
            return view('todolists.index', compact('todoLists'))->with('error', 'A database error occurred: ' . $e->getMessage());
        } catch (PDOException $e) {
            return view('todolists.index', compact('todoLists'))->with('error', 'A database connection error occurred: ' . $e->getMessage());
        }

        return view('todolists.index', compact('todoLists'));
    }

    /**
     * Store a new ToDoList.
     *
     * @param CreateToDoListRequest $request
     * @return RedirectResponse
     */
    public function store(CreateToDoListRequest $request): RedirectResponse
    {
        try {
            ToDoList::create([
                'name'    => $request->safe()->only('name')['name'],
                'user_id' => auth('web')->id(),
            ]);

            return redirect()
                ->route('lists.index')
                ->with('success', 'To Do List created successfully!');
        } catch (Throwable $e) {
            report($e); // Log the error for debugging

            return redirect()
                ->route('lists.index')
                ->with('error', 'An unexpected error occurred. Please try again.');
        }
    }


    /**
     * @param ToDoList $toDoList
     * @return Factory|View|Application
     */
    public function edit(ToDoList $toDoList): Factory|View|Application
    {        
        $this->authorizeList($toDoList);

        // Check that the ToDoList belongs to the currently authenticated user
        if ($toDoList->user_id !== auth('web')->id()) {
            abort(403, 'Unauthorized.');
        }
        return view('todolists.edit', compact('toDoList'));
    }


    /**
     * @param UpdateToDoListRequest $request
     * @param ToDoList $toDoList
     * @return RedirectResponse
     */
    public function update(UpdateToDoListRequest $request, ToDoList $toDoList): RedirectResponse
    {
        if ($toDoList->user_id !== auth('web')->id()) {
            abort(403, 'Unauthorized.');
        }

        try {
            $toDoList->update($request->safe()->all());
            return redirect()->route('lists.index')->with('success', 'To Do List updated!');
        } catch (Exception $e) {
            return redirect()->route('lists.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
        return redirect()->route('lists.index')->with('error', 'Something went wrong with To Do List Delete. ' . $e->getMessage());
    }

    /**
     * @param ToDoList $toDoList
     * @param ToDoListService $service
     * @return RedirectResponse
     */
    public function destroy(ToDoList $toDoList, ToDoListService $service): RedirectResponse
    {
        if ($toDoList->user_id !== auth('web')->id()) {
            abort(403, 'Unauthorized.');
        }
        
        try {
            $service->deleteWithItems($toDoList);
            return redirect()->route('lists.index')->with('success', 'To Do List deleted!');
        } catch (Exception $e) {
            return redirect()->route('lists.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
