<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        foreach (File::directories(app_path('Modules')) as $modulePath) {
            $moduleName = basename($modulePath);
            $provider = "App\\Modules\\{$moduleName}\\Providers\\{$moduleName}ServiceProvider";
            if (class_exists($provider)) {
                $this->app->register($provider);
            }
        }
    }
}