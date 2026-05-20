@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'w-full px-4 py-3.5 bg-zinc-950 border border-zinc-900 rounded-xl text-white placeholder-zinc-600 focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all duration-200 outline-none shadow-inner']) }}>
