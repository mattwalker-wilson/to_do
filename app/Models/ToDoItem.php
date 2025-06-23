<?php

namespace App\Models;

use Database\Factories\ToDoItemFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;


/**
 * ToDoItem Model
 *
 * This model represents an item within a to-do list.
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $completed
 * @property int $to_do_list_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ToDoList $toDoList
 * @method static ToDoItemFactory factory($count = null, $state = [])
 * @method static Builder|ToDoItem newModelQuery()
 * @method static Builder|ToDoItem newQuery()
 * @method static Builder|ToDoItem query()
 * @method static Builder|ToDoItem whereCompleted($value)
 * @method static Builder|ToDoItem whereCreatedAt($value)
 * @method static Builder|ToDoItem whereDescription($value)
 * @method static Builder|ToDoItem whereId($value)
 * @method static Builder|ToDoItem whereTitle($value)
 * @method static Builder|ToDoItem whereToDoListId($value)
 * @method static Builder|ToDoItem whereUpdatedAt($value)
 * @mixin \Eloquent
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
     * @return BelongsTo
     */
    public function toDoList(): BelongsTo
    {
        return $this->belongsTo(ToDoList::class);
    }
}
