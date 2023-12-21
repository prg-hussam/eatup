<?php

namespace Modules\ActivityLog\Enums;

use Modules\Support\Traits\EnumArrayable;

enum HttpMethodsCases: string
{
    use EnumArrayable;

    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
}
