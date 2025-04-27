<?php

namespace Database\Factories;

use App\Models\ToDoList;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToDoListFactory extends Factory
{
    protected $model = ToDoList::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'user_id' => User::factory(), // automatically create a user
        ];
    }
}
