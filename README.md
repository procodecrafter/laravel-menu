# CodeCrafter Laravel Menu

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codecrafter/laravel-menu.svg?style=flat-square)](https://packagist.org/packages/codecrafter/laravel-menu)
[![Total Downloads](https://img.shields.io/packagist/dt/codecrafter/laravel-menu.svg?style=flat-square)](https://packagist.org/packages/codecrafter/laravel-menu)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

Древовидный конструктор меню для Laravel с интеграцией в Filament 5. Поддерживает вложенные меню, мега-меню, кэширование и Blade-компоненты.

## Возможности

- 🌳 **Древовидная структура** — неограниченная вложенность через `parent_id`
- 🎨 **Мега-меню** — колонки с заголовками и ссылками
- 🔌 **Filament 5 Panel Plugin** — подключается одной строкой
- 🚀 **Кэширование** — авто-инвалидация при save/delete
- 🎯 **Группы (локации)** — `main`, `footer`, `mobile` и т.д.
- 🧩 **Blade-компоненты** — `<x-laravel-menu::main-menu />`
- ⚙️ **Artisan-команда** — `php artisan menu:clear`

## Требования

- PHP 8.2+
- Laravel 11, 12 или 13
- Filament 5.0+

## Установка

```bash
composer require codecrafter/laravel-menu
