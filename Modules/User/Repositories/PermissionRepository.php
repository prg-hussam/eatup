<?php

namespace Modules\User\Repositories;

use Nwidart\Modules\Facades\Module;

class PermissionRepository
{
    /**
     * Get the permissions from all the enabled modules.
     *
     * @return array
     */
    public static function all()
    {
        return static::getEnabledModulePermissions();
    }

    /**
     * Get the permissions from all the enabled modules and collapse
     *
     * @return array
     */
    public static function collapse()
    {
        $permissions = [];
        foreach (self::all() as $modules) {
            foreach ($modules as $preifx => $modulePermissions) {
                foreach ($modulePermissions as $permission) {
                    $permissions[] = "{$preifx}.{$permission}";
                }
            }
        }

        return $permissions;
    }

    /**
     * Get the permissions from all the enabled modules and collapse
     *
     * @return array
     */
    public static function grouped()
    {
        $permissions = [];
        foreach (self::all() as $modules) {
            foreach ($modules as $preifx => $modulePermissions) {

                $parts = explode('.', $preifx, 2);
                $moduleName = count($parts) >= 2 ? $parts[1] : $parts[0];
                $permissions[$preifx] = [
                    'title' => __("admin.{$moduleName}.{$moduleName}"),
                    'permissions' => [],
                ];
                foreach ($modulePermissions as  $permission) {
                    $permissions[$preifx]['permissions'][] = [
                        'key' => "{$preifx}.{$permission}",
                        'name' => __(
                            "admin.roles.permissions.{$permission}",
                            ["resource" => __("admin.{$moduleName}.{$moduleName}")]
                        )
                    ];
                }
            }
        }

        return $permissions;
    }

    /**
     * Get enabled module permissions.
     *
     * @return array
     */
    private static function getEnabledModulePermissions()
    {
        $permissions = [];

        foreach (Module::allEnabled() as $module) {
            $config = config('platform.modules.' . strtolower($module->getName()) . '.permissions');

            if (!is_null($config)) {
                $permissions[$module->getName()] = $config;
            }
        }

        return $permissions;
    }
}
