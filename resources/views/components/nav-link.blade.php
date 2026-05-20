@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-1 pt-1 border-b-2 border-red-600 text-sm font-black leading-5 text-white focus:outline-none transition duration-150 ease-in-out uppercase tracking-wider'
                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-bold leading-5 text-zinc-500 hover:text-zinc-200 hover:border-zinc-700 focus:outline-none transition duration-150 ease-in-out uppercase tracking-wider';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
