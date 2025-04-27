<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateToDoItemRequest;
use App\Models\ToDoList;
use App\Models\ToDoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ToDoItemWebController extends Controller
{
    public function index(ToDoList $toDoList): View
    {
        // Ensure user owns the list
        $this->authorizeList($toDoList);

        $toDoItems = $toDoList->toDoItems()->get();

        return view('todolists.todoitems.index', compact('toDoList', 'toDoItems'));
    }

    public function store(CreateToDoItemRequest $request, ToDoList $toDoList): RedirectResponse
    {
        $this->authorizeList($toDoList);

        $toDoList->toDoItems()->create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->boolean('completed')
        ]);

        return redirect()->route('lists.index', $toDoList)
            ->with('success', 'Item added!');
    }

    public function edit(ToDoList $toDoList, ToDoItem $toDoItem): View
    {
        $this->authorizeList($toDoList);
        $this->authorizeItem($toDoList, $toDoItem);

        return view('todolists.todoitems.edit', compact('toDoList', 'toDoItem'));
    }

    public function update(Request $request, ToDoList $toDoList, ToDoItem $toDoItem): RedirectResponse
    {
        $this->authorizeList($toDoList);
        $this->authorizeItem($toDoList, $toDoItem);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean'
        ]);

        $toDoItem->update([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->boolean('completed')
        ]);

        return redirect()->route('lists.index', $toDoList)
            ->with('success', 'Item updated!');
    }

    public function destroy(ToDoList $toDoList, ToDoItem $toDoItem): RedirectResponse
    {
        $this->authorizeList($toDoList);
        $this->authorizeItem($toDoList, $toDoItem);

        $toDoItem->delete();

        return redirect()->route('lists.items.index', $toDoList)
            ->with('success', 'Item deleted.');
    }

    protected function authorizeList(ToDoList $toDoList): void
    {
        if ($toDoList->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to ToDoList.');
        }
    }

    protected function authorizeItem(ToDoList $toDoList, ToDoItem $toDoItem): void
    {
        if ($toDoItem->to_do_list_id !== $toDoList->id) {
            abort(403, 'Unauthorized access to ToDoItem.');
        }
    }
}
