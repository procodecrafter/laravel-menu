@props(['item'])

@php
    $columns = $item->children->where('type', 'header');
@endphp

<div
    x-data="{ open: false }"
    @mouseenter="open = true"
    @mouseleave="open = false"
    class="relative"
>
    <button
        type="button"
        class="flex items-center gap-1 text-sm font-semibold text-gray-800 hover:text-blue-600"
        aria-haspopup="true"
        :aria-expanded="open"
    >
        {{ $item->label }}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute left-0 mt-2 min-w-96 bg-white rounded-lg shadow-lg border border-gray-200 z-50 overflow-hidden"
    >
        @if($columns->isNotEmpty())
            @php
                $cols = min($columns->count(), 3);
                $gridClass = match($cols) {
                    1 => 'grid-cols-1',
                    2 => 'grid-cols-2',
                    default => 'grid-cols-3',
                };
            @endphp

            <div class="grid {{ $gridClass }} gap-4 p-4">
                @foreach($columns as $column)
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            {{ $column->label }}
                        </h3>
                        <ul class="space-y-1">
                            @foreach($column->children as $link)
                                <li>
                                    <a href="{{ $link->url ?? '#' }}"
                                       target="{{ $link->target }}"
                                       class="block text-sm text-gray-700 hover:text-blue-600">
                                        {{ $link->label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Плоский список, если нет header-колонок --}}
            <ul class="p-4 space-y-1">
                @foreach($item->children as $child)
                    <li>
                        <a href="{{ $child->url ?? '#' }}"
                           target="{{ $child->target }}"
                           class="block text-sm text-gray-700 hover:text-blue-600">
                            {{ $child->label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        @if($item->url && $item->url !== '#')
            <div class="border-t border-gray-200 px-4 py-3">
                <a href="{{ $item->url }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                    Все →
                </a>
            </div>
        @endif
    </div>
</div>
