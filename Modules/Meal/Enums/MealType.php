<?php

namespace Modules\Meal\Enums;

use Modules\Support\Traits\EnumArrayable;

enum MealType: string
{
    use EnumArrayable;

    case Count = 'count';
    case Weight = 'weight';
}