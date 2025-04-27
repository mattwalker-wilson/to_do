<?php
namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Models\User;
use App\Models\ToDoList;
use App\Models\ToDoItem;
use App\Services\ToDoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ToDoListServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws Exception
     */
    public function test_it_deletes_todo_list_and_items_in_transaction()
    {
        $user = User::factory()->create();

        $list = ToDoList::factory()->create(['user_id' => $user->id]);

        $items = ToDoItem::factory()->count(3)->create(['to_do_list_id' => $list->id]);

        $service = new ToDoListService();
        $service->deleteWithItems($list);

        $this->assertDatabaseMissing('to_do_lists', ['id' => $list->id]);
        foreach ($items as $item) {
            $this->assertDatabaseMissing('to_do_items', ['id' => $item->id]);
        }
    }
}
