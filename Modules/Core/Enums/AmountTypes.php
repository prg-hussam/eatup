<?php

namespace Modules\Core\Enums;

use Modules\Support\Traits\EnumArrayable;

enum AmountTypes: string
{
    use EnumArrayable;

    case Fixed = 'fixed';
    case Percent = 'percent';
}
