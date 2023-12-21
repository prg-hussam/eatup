<?php

namespace Modules\User\Repositories;

class RoleRepository
{
    /**
     * Application main roles
     */
    public const SUPER_ADMIN = 'super-admin';

    /**
     * Get all roles
     *
     * @return array
     */
    public static function all(): array
    {
        return [self::SUPER_ADMIN];
    }
}
