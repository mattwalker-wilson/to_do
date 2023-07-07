<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * ToDoItem Model
 * 
 * This model represents an item within a to-do list.
 * 
 */
class ToDoItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'completed',
        'to_do_list_id'
    ];

    /**
     * Get the to-do list that owns the to-do item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toDoList()
    {
        return $this->belongsTo(ToDoList::class);
    }
}
