<?php

declare(strict_types=1);

namespace CodeCrafter\Menu\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class MenuItem extends Model
{
    protected $fillable = [
        'parent_id',
        'group',
        'label',
        'url',
        'type',
        'target',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    /**
     * Отключить timestamps, если в миграции их нет.
     * Оставляем по умолчанию — timestamps есть.
     */

    // ============================================================
    // Relations
    // ============================================================

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order');
    }

    // ============================================================
    // Tree loading with cache
    // ============================================================

    /**
     * Получить дерево меню для группы, с кэшем.
     *
     * @return Collection<int, static>
     */
    public static function tree(string $group = 'main'): Collection
    {
        $cacheKey = static::cacheKey($group);
        $ttl      = (int) config('menu.cache_ttl', 3600);

        return Cache::remember($cacheKey, $ttl, function () use ($group) {
            return static::query()
                ->where('group', $group)
                ->where('is_active', true)
                ->whereNull('parent_id')
                ->with([
                    'children' => fn ($q) => $q->where('is_active', true)->orderBy('order'),
                    'children.children' => fn ($q) => $q->where('is_active', true)->orderBy('order'),
                ])
                ->orderBy('order')
                ->get();
        });
    }

    // ============================================================
    // Cache invalidation
    // ============================================================

    protected static function booted(): void
    {
        static::saved(function (self $item): void {
            static::forgetCache($item->group);
            static::forgetCache($item->getOriginal('group'));
        });

        static::deleted(function (self $item): void {
            static::forgetCache($item->group);
        });
    }

    public static function cacheKey(string $group): string
    {
        return "codecrafter.menu.tree.{$group}";
    }

    public static function forgetCache(?string $group): void
    {
        if ($group === null) {
            return;
        }

        Cache::forget(static::cacheKey($group));
    }

    /**
     * Сбросить кэш для всех групп (используется artisan-командой).
     */
    public static function forgetAllCaches(): void
    {
        foreach (static::query()->distinct()->pluck('group') as $group) {
            static::forgetCache($group);
        }

        // Также чистим ключи для групп, которые сейчас пусты, но могут быть указаны в конфиге.
        foreach ((array) config('menu.groups', []) as $group => $_label) {
            static::forgetCache($group);
        }
    }
}
