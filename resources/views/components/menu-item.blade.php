@props(['item'])

@if($item->type === 'divider')
    <div class="border-t border-gray-200 my-1"></div>
@elseif($item->type === 'header')
    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-2 py-1">
        {{ $item->label }}
    </div>
@else
    <a href="{{ $item->url ?? '#' }}"
       target="{{ $item->target }}"
       class="block text-sm text-gray-700 hover:text-blue-600 px-2 py-1">
        {{ $item->label }}
    </a>
@endif
