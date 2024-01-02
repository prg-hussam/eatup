<?php

namespace Modules\Core\Enums;

use Modules\Support\Traits\EnumArrayable;

enum PaymentStatus: string
{
    use EnumArrayable;

    case Paid = 'paid';
    case Unpaid = 'unpaid';
}