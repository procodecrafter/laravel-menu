<?php

declare(strict_types=1);

namespace CodeCrafter\Menu\Filament\Resources\MenuItems\Tables;

use CodeCrafter\Menu\Models\MenuItem;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MenuItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group')
                    ->label('Группа')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => config("menu.groups.{$state}", $state))
                    ->sortable(),

                TextColumn::make('label')
                    ->label('Название')
                    ->description(fn (MenuItem $r) => $r->parent?->label ? '↳ ' . $r->parent->label : null)
                    ->searchable(),

                TextColumn::make('url')
                    ->label('URL')
                    ->limit(40)
                    ->toggleable(),

                TextColumn::make('type')
                    ->label('Тип')
                    ->badge(),

                TextColumn::make('order')
                    ->label('Порядок')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Активен')
                    ->boolean(),
            ])
            ->defaultSort('group')
            ->reorderable('order')
            ->filters([
                SelectFilter::make('group')
                    ->label('Группа')
                    ->options(fn () => config('menu.groups', ['main' => 'Главное меню'])),

                TernaryFilter::make('is_active')->label('Активен'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
