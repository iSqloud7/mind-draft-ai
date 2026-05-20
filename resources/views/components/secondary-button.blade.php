<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 text-zinc-300 hover:text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all duration-200 focus:outline-none']) }}>
    {{ $slot }}
</button>
