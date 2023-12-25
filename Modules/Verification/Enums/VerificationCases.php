<?php

namespace Modules\Verification\Enums;

use Modules\Support\Traits\EnumArrayable;

enum VerificationCases: string
{
    use EnumArrayable;

    case Register = 'register';
    case Login = 'login';
    case ResetPasswords = "resetPasswords";
}