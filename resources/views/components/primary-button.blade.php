<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3.5 bg-red-600 hover:bg-red-700 text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-[0_4px_20px_rgba(220,38,38,0.2)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 focus:outline-none']) }}>
    {{ $slot }}
</button>
