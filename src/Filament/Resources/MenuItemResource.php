<?php

declare(strict_types=1);

namespace CodeCrafter\Menu\Filament\Resources;

use CodeCrafter\Menu\Filament\Resources\MenuItems\Pages\CreateMenuItem;
use CodeCrafter\Menu\Filament\Resources\MenuItems\Pages\EditMenuItem;
use CodeCrafter\Menu\Filament\Resources\MenuItems\Pages\ListMenuItems;
use CodeCrafter\Menu\Filament\Resources\MenuItems\Schemas\MenuItemForm;
use CodeCrafter\Menu\Filament\Resources\MenuItems\Tables\MenuItemsTable;
use CodeCrafter\Menu\Models\MenuItem;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static ?string $recordTitleAttribute = 'label';

    public static function getNavigationIcon(): string
    {
        return (string) config('menu.filament.navigation_icon', 'heroicon-o-bars-3');
    }

    public static function getNavigationGroup(): ?string
    {
        return config('menu.filament.navigation_group');
    }

    public static function getNavigationSort(): ?int
    {
        return config('menu.filament.navigation_sort');
    }

    public static function getNavigationLabel(): string
    {
        return 'Меню';
    }

    public static function getModelLabel(): string
    {
        return 'пункт меню';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Меню';
    }

    public static function form(Schema $schema): Schema
    {
        return MenuItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MenuItemsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListMenuItems::route('/'),
            'create' => CreateMenuItem::route('/create'),
            'edit'   => EditMenuItem::route('/{record}/edit'),
        ];
    }
}
