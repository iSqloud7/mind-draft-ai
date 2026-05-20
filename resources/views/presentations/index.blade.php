<x-app-layout>
    <div class="min-h-screen bg-black text-white">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 py-12">

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-16 gap-6">
                <div>
                    <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight uppercase">
                        My <span class="text-red-600">Presentations</span>
                    </h1>
                    <p class="mt-2 text-zinc-500 font-medium tracking-wide">
                        {{ $presentations->count() }} total drafts available in MindDraft
                    </p>
                </div>
                <a href="/presentations/create"
                   class="inline-flex items-center gap-3 bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-4 rounded-xl shadow-[0_4px_20px_rgba(220,38,38,0.25)] transition-all duration-300 hover:scale-[1.02] uppercase tracking-widest text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Presentation
                </a>
            </div>

            @if($presentations->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 text-center border border-zinc-900 bg-zinc-950/40 rounded-2xl p-8">
                    <div class="bg-red-600/10 rounded-full p-6 mb-6 border border-red-600/20">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2 uppercase tracking-wide">No drafts found</h3>
                    <p class="text-zinc-500 mb-8 max-w-sm text-sm">Bring your ideas to life with AI. Create your first presentation now.</p>
                    <a href="/presentations/create"
                       class="bg-white text-black hover:bg-red-600 hover:text-white font-black px-8 py-3.5 rounded-xl transition-all duration-200 uppercase tracking-widest text-xs">
                        Create Draft
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                    @foreach($presentations as $p)
                        <div class="group bg-zinc-950 rounded-2xl border border-zinc-900 hover:border-red-600/40 transition-all duration-300 flex flex-col overflow-hidden shadow-xl h-full">
                            <div class="h-1 bg-zinc-900 group-hover:bg-red-600 transition-colors duration-300"></div>

                            <div class="p-8 flex flex-col flex-1 justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-6">
                                        <span class="text-[10px] font-black bg-red-600/10 text-red-500 border border-red-900/40 px-3 py-1 rounded-md uppercase tracking-wider">
                                            {{ count($p->structure['slides'] ?? []) }} slides
                                        </span>
                                        <span class="text-[10px] text-zinc-600 font-bold uppercase tracking-widest">
                                            {{ $p->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <div class="h-14 mb-2 overflow-hidden">
                                        <h2 class="text-xl font-bold text-white group-hover:text-red-500 transition-colors uppercase tracking-tight line-clamp-2">
                                            {{ $p->title }}
                                        </h2>
                                    </div>

                                    <div class="h-16 overflow-hidden mb-4">
                                        <p class="text-sm text-zinc-500 line-clamp-3">
                                            {{ $p->topic }}
                                        </p>
                                    </div>

                                    <button type="button"
                                            onclick="openPreviewModal('{{ e($p->title) }}', '{{ e($p->topic) }}', '{{ count($p->structure['slides'] ?? []) }}', '{{ $p->created_at->diffForHumans() }}')"
                                            class="text-xs font-black text-red-500 hover:text-red-400 uppercase tracking-widest transition-colors block mb-6">
                                        Show More →
                                    </button>
                                </div>

                                <div class="pt-6 border-t border-zinc-900 flex items-center gap-3">
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

    <div id="preview-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/80 backdrop-blur-md transition-all duration-300">
        <div class="bg-zinc-950 w-full max-w-xl rounded-2xl border border-zinc-900 p-8 shadow-[0_0_50px_rgba(220,38,38,0.15)] flex flex-col max-h-[85vh]">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-zinc-900">
                <div class="flex items-center gap-3">
                    <span id="modal-slides" class="text-[10px] font-black bg-red-600/10 text-red-500 border border-red-900/40 px-3 py-1 rounded-md uppercase tracking-wider"></span>
                    <span id="modal-date" class="text-[10px] text-zinc-600 font-bold uppercase tracking-widest"></span>
                </div>
                <button onclick="closePreviewModal()" class="text-zinc-500 hover:text-white transition-colors p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto space-y-4 pr-2 custom-scrollbar">
                <h2 id="modal-title" class="text-2xl font-black text-white uppercase tracking-tight break-words leading-tight"></h2>
                <p id="modal-topic" class="text-zinc-400 text-sm leading-relaxed break-words pt-2"></p>
            </div>

            <div class="mt-8 pt-4 border-t border-zinc-900 flex justify-end">
                <button onclick="closePreviewModal()" class="bg-zinc-900 hover:bg-zinc-800 text-white font-bold text-xs uppercase tracking-widest px-6 py-3 rounded-xl border border-zinc-800 transition-all">
                    Close Draft Preview
                </button>
            </div>
        </div>
    </div>

    <script>
        function openPreviewModal(title, topic, slides, date) {
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-topic').textContent = topic;
            document.getElementById('modal-slides').textContent = `${slides} slides`;
            document.getElementById('modal-date').textContent = date;

            const modal = document.getElementById('preview-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closePreviewModal() {
            const modal = document.getElementById('preview-modal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('preview-modal');
            if (event.target == modal) {
                closePreviewModal();
            }
        }
    </script>
</x-app-layout>
