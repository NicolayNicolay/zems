<?php

declare(strict_types=1);

namespace Modules\Enums;

use Modules\Traits\EnumToArray;

enum StatusEnum: int
{
    use EnumToArray;

    case ideas = 1;
    case todos = 2;
    case inProgress = 3;
    case completed = 4;
}
