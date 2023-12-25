<?php

namespace Modules\Verification\Enums;

use Modules\Support\Traits\EnumArrayable;

enum VerificationChannelsCases: string
{
    use EnumArrayable;

    case Phone = 'phone';
}