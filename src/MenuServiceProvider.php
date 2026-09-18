<?php

declare(strict_types=1);

namespace CodeCrafter\Menu;

use CodeCrafter\Menu\Console\ClearMenuCache;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MenuServiceProvider extends PackageServiceProvider
{
    public static string $name = 'laravel-menu';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile('menu')
            ->hasViews('laravel-menu')
            ->hasMigration('create_menu_items_table')
            ->hasCommand(ClearMenuCache::class);
    }
}