<?php

declare(strict_types=1);

namespace CodeCrafter\Menu\Filament\Resources\MenuItems\Schemas;

use CodeCrafter\Menu\Models\MenuItem;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('group')
                ->label('Группа')
                ->options(fn () => config('menu.groups', ['main' => 'Главное меню']))
                ->default('main')
                ->required()
                ->live(),

            Select::make('parent_id')
                ->label('Родительский пункт')
                ->options(function (?MenuItem $record) {
                    $items = MenuItem::query()
                        ->orderBy('group')
                        ->orderBy('order')
                        ->get();

                    $tree        = [];
                    $byParent    = $items->groupBy('parent_id');
                    $selfId      = $record?->id;

                    $build = function ($parentId, int $depth = 0) use (&$build, $byParent, $selfId, &$tree) {
                        foreach ($byParent[$parentId] ?? [] as $item) {
                            if ($item->id === $selfId) {
                                continue;
                            }

                            $prefix = str_repeat('— ', $depth);
                            $tree[$item->id] = "{$prefix}[{$item->group}] {$item->label}";

                            $build($item->id, $depth + 1);
                        }
                    };

                    $build(null);

                    return $tree;
                })
                ->searchable()
                ->preload()
                ->nullable()
                ->helperText('Оставьте пустым для пункта верхнего уровня'),

            Select::make('type')
                ->label('Тип')
                ->options([
                    'link'    => 'Ссылка',
                    'header'  => 'Заголовок',
                    'divider' => 'Разделитель',
                ])
                ->default('link')
                ->required()
                ->live(),

            TextInput::make('label')
                ->label('Название')
                ->required()
                ->maxLength(255),

            TextInput::make('url')
                ->label('URL')
                ->maxLength(255)
                ->visible(fn (Get $get) => $get('type') === 'link')
                ->required(fn (Get $get) => $get('type') === 'link'),

            Select::make('target')
                ->label('Открывать')
                ->options([
                    '_self'  => 'В текущем окне',
                    '_blank' => 'В новой вкладке',
                ])
                ->default('_self')
                ->visible(fn (Get $get) => $get('type') === 'link'),

            TextInput::make('order')
                ->label('Порядок')
                ->numeric()
                ->default(0),

            Toggle::make('is_active')
                ->label('Активен')
                ->default(true),
        ]);
    }
}
