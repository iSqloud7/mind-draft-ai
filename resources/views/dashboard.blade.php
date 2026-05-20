<x-app-layout>
    <div class="min-h-screen bg-black text-white">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 py-12">

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-16 gap-6">
                <div>
                    <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight uppercase">
                        My <span class="text-red-600">Presentations</span>
                    </h1>
                    <p class="mt-2 text-zinc-500 font-medium tracking-wide">
                        {{ $presentations->count() }} presentation{{ $presentations->count() !== 1 ? 's' : '' }} created
                    </p>
                </div>
                <a href="/presentations/create"
                   class="inline-flex items-center gap-3 bg-red-600 hover:bg-red-700 text-white font-black px-8 py-4 rounded-xl shadow-[0_4px_20px_rgba(220,38,38,0.25)] transition-all duration-300 hover:scale-[1.02] uppercase tracking-widest text-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Presentation
                </a>
            </div>

            @if($presentations->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 text-center border border-zinc-900 bg-zinc-950/40 rounded-2xl p-8">
                    <div class="bg-red-600/10 rounded-full p-6 mb-6 border border-red-600/20">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2 uppercase tracking-wide">No presentations yet</h3>
                    <p class="text-zinc-500 mb-8 max-w-sm text-sm">Create your first AI-powered presentation in seconds.</p>
                    <a href="/presentations/create"
                       class="bg-white text-black hover:bg-red-600 hover:text-white font-black px-8 py-4 rounded-xl shadow transition-all duration-200 hover:scale-[1.02] uppercase tracking-widest text-xs">
                        Create your first presentation
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($presentations as $p)
                        <div class="group bg-zinc-950 rounded-2xl border border-zinc-900 hover:border-red-600/40 transition-all duration-300 flex flex-col overflow-hidden shadow-xl">

                            <div class="h-1 bg-zinc-900 group-hover:bg-red-600 transition-colors duration-300"></div>

                            <div class="p-8 flex flex-col flex-1">
                                <div class="flex items-center justify-between mb-6">
                                    <span class="text-[10px] font-black bg-red-600/10 text-red-500 border border-red-900/40 px-3 py-1 rounded-md uppercase tracking-wider">
                                        {{ count($p->structure['slides'] ?? []) }} slides
                                    </span>
                                    <span class="text-[10px] text-zinc-600 font-bold uppercase tracking-widest">
                                        {{ $p->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <h2 class="text-xl font-bold text-white mb-2 group-hover:text-red-500 transition-colors line-clamp-1 uppercase tracking-tight">
                                    {{ $p->title }}
                                </h2>
                                <p class="text-sm text-zinc-500 mb-8 line-clamp-2 min-h-[40px]">
                                    {{ $p->topic }}
                                </p>

                                <div class="mt-auto pt-6 border-t border-zinc-900 flex items-center gap-3">
                                    <a href="/presentations/{{ $p->id }}"
                                       class="flex-1 text-center bg-zinc-900 hover:bg-red-600 text-white text-xs font-black py-3.5 rounded-xl transition-all uppercase tracking-widest border border-zinc-800 hover:border-red-600">
                                        Open
                                    </a>
                                    <a href="/presentations/{{ $p->id }}/edit"
                                       class="px-4 py-3.5 bg-zinc-900 hover:bg-zinc-800 text-zinc-400 hover:text-white rounded-xl transition-all border border-zinc-800 text-xs font-bold uppercase tracking-wider">
                                        Edit
                                    </a>
                                    <form method="POST" action="/presentations/{{ $p->id }}" onsubmit="return confirm('Delete this presentation?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-zinc-900 hover:bg-red-950/40 text-zinc-600 hover:text-red-500 p-3.5 rounded-xl transition-all border border-zinc-800 hover:border-red-900/30">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
