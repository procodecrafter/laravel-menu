<?php

declare(strict_types=1);

namespace CodeCrafter\Menu\Filament\Resources\MenuItems\Pages;

use CodeCrafter\Menu\Filament\Resources\MenuItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMenuItems extends ListRecords
{
    protected static string $resource = MenuItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
