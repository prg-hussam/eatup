<?php

namespace Modules\Support\Enums;

use Modules\Support\Traits\EnumArrayable;

enum MailEncryptionProtocols: string
{
    use EnumArrayable;

    case SSL = 'ssl';
    case Tls = 'tls';
}
