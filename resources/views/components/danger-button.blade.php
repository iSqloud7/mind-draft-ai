<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-[0_0_15px_rgba(220,38,38,0.2)] hover:scale-[1.02] transition-all duration-200 focus:outline-none']) }}>
    {{ $slot }}
</button>
