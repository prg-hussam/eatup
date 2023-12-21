<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Module;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->app['modules']->allEnabled() as $module) {
            $this->loadConfigs($module);
            $this->loadMigrations($module);
        }
    }

    /**
     * Load migrations for the given module.
     *
     * @param  \Nwidart\Modules\Module  $module
     * @return void
     */
    private function loadConfigs(Module $module)
    {
        collect([
            'config' => "{$module->getPath()}/Config/config.php",
            'assets' => "{$module->getPath()}/Config/assets.php",
            'permissions' => "{$module->getPath()}/Config/permissions.php",
        ])->filter(function ($path) {
            return file_exists($path);
        })->each(function ($path, $filename) use ($module) {
            $this->mergeConfigFrom($path, "platform.modules.{$module->getLowerName()}.{$filename}");
        });
    }

    /**
     * Load migrations for the given module.
     *
     * @param  \Nwidart\Modules\Module  $module
     * @return void
     */
    private function loadMigrations(Module $module)
    {
        $this->loadMigrationsFrom("{$module->getPath()}/Database/Migrations");
    }
}
