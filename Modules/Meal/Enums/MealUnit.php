<?php

namespace Modules\Meal\Enums;

use Modules\Support\Traits\EnumArrayable;

enum MealUnit: string
{
    use EnumArrayable;

    case Piece = 'piece';
    case Gram = 'gram';
}