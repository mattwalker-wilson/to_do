<?php

namespace App\Models;

use App\Models\ToDoItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToDoList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toDoItems()
    {
        return $this->hasMany(ToDoItem::class);
    }

}
