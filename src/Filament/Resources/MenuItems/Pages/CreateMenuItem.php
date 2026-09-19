<?php

declare(strict_types=1);

namespace CodeCrafter\Menu\Filament\Resources\MenuItems\Pages;

use CodeCrafter\Menu\Filament\Resources\MenuItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMenuItem extends CreateRecord
{
    protected static string $resource = MenuItemResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
