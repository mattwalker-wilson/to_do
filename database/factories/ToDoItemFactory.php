<?php

namespace Database\Factories;

use App\Models\ToDoItem;
use App\Models\ToDoList;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToDoItemFactory extends Factory
{
    protected $model = ToDoItem::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'completed' => false,
            'to_do_list_id' => ToDoList::factory(),
        ];
    }
}
