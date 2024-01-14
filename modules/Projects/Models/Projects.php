<?php

namespace Modules\Projects\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Tasks\Models\Tasks;
use Modules\Traits\ObjectsMutators;
use Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Advertisement
 *
 * @mixin Builder
 *
 * @property int $id
 * @property mixed|null $created_at
 * @property mixed|null $updated_at
 * @property string $name
 * @property string $description
 * @property int $created_user_id Автор
 *
 */
class Projects extends Model
{
    use HasFactory;
    use ObjectsMutators;

    protected $fillable = [
        'name',
        'description',
        'create_user_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'date:d.m.Y H:i:s',
    ];
    protected $appends = [
        'user_data',
        'tasks_count',
    ];

    public function tasks(): ?HasMany
    {
        return $this->HasMany(Tasks::class, 'project_id', 'id') ?? null;
    }

    public function getTasksCountAttribute(): int
    {
        return $this->tasks()->count();
    }
}
