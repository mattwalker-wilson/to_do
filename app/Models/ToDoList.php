<?php

namespace App\Models;

use Database\Factories\ToDoListFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ToDoList
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection|ToDoItem[] $toDoItems
 * @method static Builder where(string $column, string $operator = null, mixed $value = null)
 * @method static static create(array $attributes = [])
 * @property-read int|null $to_do_items_count
 * @property-read User $user
 * @method static ToDoListFactory factory($count = null, $state = [])
 * @method static Builder|ToDoList newModelQuery()
 * @method static Builder|ToDoList newQuery()
 * @method static Builder|ToDoList query()
 * @method static Builder|ToDoList whereCreatedAt($value)
 * @method static Builder|ToDoList whereId($value)
 * @method static Builder|ToDoList whereName($value)
 * @method static Builder|ToDoList whereUpdatedAt($value)
 * @method static Builder|ToDoList whereUserId($value)
 * @mixin \Eloquent
 */
class ToDoList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toDoItems(): HasMany
    {
        return $this->hasMany(ToDoItem::class);
    }

}
