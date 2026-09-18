<?php

declare(strict_types=1);

namespace CodeCrafter\Menu;

use CodeCrafter\Menu\Filament\Resources\MenuItemResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class MenuPlugin implements Plugin
{
    public function getId(): string
    {
        return 'codecrafter-menu';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            MenuItemResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }
}