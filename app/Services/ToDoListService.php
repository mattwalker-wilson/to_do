<?php

namespace App\Services;

use App\Models\ToDoList;
use Illuminate\Support\Facades\DB;
use Exception;

class ToDoListService
{
    /**
     * Delete a ToDoList and its related items within a transaction.
     *
     * @param ToDoList $toDoList
     * @throws Exception
     */
    public function deleteWithItems(ToDoList $toDoList): void
    {
        DB::transaction(function () use ($toDoList) {
            $toDoList->toDoItems()->delete();
            $toDoList->delete();
        });
    }
}
