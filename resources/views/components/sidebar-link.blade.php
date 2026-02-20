@props(['active', 'icon' => ''])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 text-sm font-semibold text-white bg-indigo-800 rounded-lg shadow-inner group'
            : 'flex items-center px-4 py-3 text-sm font-medium text-indigo-100 hover:text-white hover:bg-indigo-600 rounded-lg transition-all duration-200 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
    <svg class="w-5 h-5 me-3 text-indigo-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
    </svg>
    @endif
    {{ $slot }}
</a>