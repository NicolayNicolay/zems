<?php

declare(strict_types=1);

namespace Modules\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Users\Models\User;

trait ObjectsMutators
{
    public function user(): ?HasOne
    {
        return $this->HasOne(User::class, 'id', 'create_user_id') ?? null;
    }
    /**
     * This will change date according to timezone.
     */
    public function getCreatedAtAttribute($value): string
    {
        return $this->asDateTime($value)->setTimezone('Europe/Moscow')->format('d.m.Y H:i:s');
    }

    /**
     * This will change date according to timezone.
     */
    public function getUpdatedAtAttribute($value): string
    {
        return $this->asDateTime($value)->setTimezone('Europe/Moscow')->format('d.m.Y H:i:s');
    }

    public function getUserDataAttribute(): Model
    {
        return $this->user()->first();
    }
}
