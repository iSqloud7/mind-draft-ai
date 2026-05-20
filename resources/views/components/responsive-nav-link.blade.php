@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'block w-full ps-3 pr-4 py-3 border-l-4 border-red-600 text-start text-base font-black text-red-500 bg-red-600/10 focus:outline-none transition duration-150 ease-in-out uppercase tracking-wider'
                : 'block w-full ps-3 pr-4 py-3 border-l-4 border-transparent text-start text-base font-bold text-zinc-400 hover:text-white hover:bg-zinc-900 hover:border-zinc-700 focus:outline-none transition duration-150 ease-in-out uppercase tracking-wider';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
