<?php

declare(strict_types=1);

namespace Modules\Tasks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Traits\ObjectsMutators;
use Modules\Users\Models\User;

class Tasks extends Model
{
    use HasFactory;
    use ObjectsMutators;

    protected $fillable = [
        'name',
        'description',
        'start',
        'end',
        'state',
        'make_user_id',
        'create_user_id',
        'project_id',
    ];

    protected $casts = [
        'created_at' => 'date:d.m.Y H:i:s',
        'start'      => 'date:d.m.Y H:i:s',
        'end'        => 'date:d.m.Y H:i:s',
    ];

    protected $appends = [
        'user_data',
        'make_user_data',
        'short_description',
    ];

    public function makeUser(): ?HasOne
    {
        return $this->HasOne(User::class, 'id', 'make_user_id') ?? null;
    }

    public function getMakeUserDataAttribute(): ?Model
    {
        return $this->makeUser()->first();
    }

    public function getShortDescriptionAttribute(): string
    {
        if ($this->description) {
            return strlen($this->description) > 200 ? substr($this->description, 0, 200) . '...' : $this->description;
        } else {
            return '';
        }
    }
}
