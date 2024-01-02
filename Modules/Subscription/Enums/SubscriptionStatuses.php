<?php

namespace Modules\Subscription\Enums;

use Modules\Support\Traits\EnumArrayable;

enum SubscriptionStatuses: string
{
    use EnumArrayable;

    case Active = 'active';
    case Expired = 'expired';
}