@props(['group' => 'main'])

@php
    $items = \CodeCrafter\Menu\Models\MenuItem::tree($group);
@endphp

@if($items->isNotEmpty())
    <nav {{ $attributes->merge(['class' => 'flex items-center gap-6']) }}>
        @foreach($items as $item)
            @if($item->type === 'divider')
                @continue
            @endif

            @if($item->children->isNotEmpty())
                <x-laravel-menu::mega-menu :item="$item" />
            @else
                <a href="{{ $item->url ?? '#' }}"
                   target="{{ $item->target }}"
                   class="text-sm font-semibold text-gray-800 hover:text-blue-600 whitespace-nowrap">
                    {{ $item->label }}
                </a>
            @endif
        @endforeach
    </nav>
@endif
