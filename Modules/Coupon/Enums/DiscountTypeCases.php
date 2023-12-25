<?php

namespace Modules\Coupon\Enums;

use Modules\Support\Traits\EnumArrayable;

enum DiscountTypeCases: string
{
    use EnumArrayable;

    case Fixed = 'fixed';
    case Percent = 'percent';
}
