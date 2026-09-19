<?php

declare(strict_types=1);

namespace CodeCrafter\Menu\Console;

use CodeCrafter\Menu\Models\MenuItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearMenuCache extends Command
{
    protected $signature = 'menu:clear';

    protected $description = 'Очистить кэш дерева меню (все группы)';

    public function handle(): int
    {
        if (config('menu.cache_ttl', 0) <= 0) {
            $this->warn('Кэширование меню отключено (menu.cache_ttl = 0). Нечего очищать.');
            return self::SUCCESS;
        }

        $groups = MenuItem::query()
            ->distinct()
            ->pluck('group')
            ->merge(array_keys((array) config('menu.groups', [])))
            ->unique()
            ->filter()
            ->values();

        if ($groups->isEmpty()) {
            $this->info('Нет групп меню для очистки.');
            return self::SUCCESS;
        }

        foreach ($groups as $group) {
            Cache::forget(MenuItem::cacheKey($group));
            $this->line("  ✓ Очищено: <fg=green>{$group}</>");
        }

        $this->newLine();
        $this->info("Очищено групп: {$groups->count()}");

        return self::SUCCESS;
    }
}
