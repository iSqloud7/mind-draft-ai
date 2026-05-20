<x-app-layout>
    <div class="min-h-screen bg-black text-white py-12">
        <div class="max-w-4xl mx-auto px-6 sm:px-8 lg:px-10">

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-12 gap-6">
                <div>
                    <a href="/presentations/{{ $presentation->id }}" class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-red-500 mb-3 transition-colors font-bold uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back to presentation
                    </a>
                    <h1 class="text-3xl font-black text-white uppercase tracking-tight">Edit Presentation</h1>
                    <p class="text-zinc-500 font-medium tracking-wide mt-1">{{ $presentation->title }}</p>
                </div>
                <button form="edit-form" type="submit"
                        class="inline-flex items-center gap-3 bg-red-600 hover:bg-red-700 text-white font-black px-8 py-4 rounded-xl shadow-[0_4px_20px_rgba(220,38,38,0.25)] transition-all duration-300 hover:scale-[1.02] uppercase tracking-widest text-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>

            <form method="POST" action="/presentations/{{ $presentation->id }}" id="edit-form" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-zinc-950 rounded-2xl shadow-xl border border-zinc-900 p-8">
                    <h2 class="text-xs font-black text-zinc-500 uppercase tracking-widest mb-6">Presentation Info</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-zinc-400 mb-2">Title</label>
                            <input type="text" name="title" value="{{ $presentation->title }}"
                                   class="w-full px-4 py-3.5 rounded-xl border border-zinc-900 bg-zinc-950 text-white placeholder-zinc-700 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-zinc-400 mb-2">Topic</label>
                            <input type="text" name="topic" value="{{ $presentation->topic }}"
                                   class="w-full px-4 py-3.5 rounded-xl border border-zinc-900 bg-zinc-950 text-white placeholder-zinc-700 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200 outline-none">
                        </div>
                    </div>
                </div>

                <div id="slides-container" class="space-y-6">
                    @foreach($presentation->structure['slides'] as $index => $slide)
                        <div class="slide-card bg-zinc-950 rounded-2xl shadow-xl border border-zinc-900 overflow-hidden"
                             data-index="{{ $index }}">

                            <div class="flex items-center gap-4 px-6 py-4 bg-zinc-900/40 border-b border-zinc-900 cursor-grab select-none">
                                <svg class="w-5 h-5 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                                <span class="text-xs font-black text-red-500 uppercase tracking-widest slide-number">Slide {{ $index + 1 }}</span>
                                <div class="ml-auto">
                                    <form method="POST" action="/presentations/{{ $presentation->id }}/regenerate-slide/{{ $index }}">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center gap-2 text-xs font-black bg-red-600/10 hover:bg-red-600/20 text-red-500 border border-red-900/40 px-4 py-2 rounded-xl transition-all uppercase tracking-widest">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Regenerate with AI
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="p-8 space-y-6">
                                <div>
                                    <label class="block text-xs font-black uppercase tracking-widest text-zinc-500 mb-2">Slide Title</label>
                                    <input type="text"
                                           name="slides[{{ $index }}][title]"
                                           value="{{ $slide['title'] }}"
                                           class="w-full px-4 py-3.5 rounded-xl border border-zinc-900 bg-zinc-950 text-white font-bold focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200 outline-none">
                                </div>

                                <div>
                                    <label class="block text-xs font-black uppercase tracking-widest text-zinc-500 mb-3">Bullet Points</label>
                                    <div class="space-y-3">
                                        @foreach($slide['bullets'] as $bIndex => $bullet)
                                            <div class="flex items-center gap-3">
                                                <span class="w-2 h-2 rounded-full bg-red-600 flex-shrink-0 shadow-[0_0_8px_rgba(220,38,38,0.8)]"></span>
                                                <input type="text"
                                                       name="slides[{{ $index }}][bullets][{{ $bIndex }}]"
                                                       value="{{ $bullet }}"
                                                       class="flex-1 px-4 py-3 rounded-xl border border-zinc-900 bg-zinc-950 text-white focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200 outline-none text-sm font-semibold">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-black uppercase tracking-widest text-zinc-500 mb-2">Speaker Notes</label>
                                    <textarea name="slides[{{ $index }}][notes]"
                                              rows="3"
                                              class="w-full px-4 py-3 rounded-xl border border-zinc-900 bg-zinc-900/20 text-zinc-300 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200 outline-none text-sm resize-none font-medium leading-relaxed">{{ trim($slide['notes']) }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </form>

            <div class="mt-8 flex justify-end">
                <button form="edit-form" type="submit"
                        class="inline-flex items-center gap-3 bg-red-600 hover:bg-red-700 text-white font-black px-10 py-4 rounded-xl shadow-[0_4px_20px_rgba(220,38,38,0.25)] transition-all duration-300 hover:scale-[1.02] uppercase tracking-widest text-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save All Changes
                </button>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        const container = document.getElementById('slides-container');
        Sortable.create(container, {
            animation: 200,
            handle: '.cursor-grab',
            onEnd: function () {
                document.querySelectorAll('.slide-card').forEach((card, index) => {
                    card.querySelectorAll('input, textarea').forEach(input => {
                        input.name = input.name.replace(/slides\[\d+\]/, `slides[${index}]`);
                    });
                    card.querySelector('.slide-number').textContent = `Slide ${index + 1}`;
                });
            }
        });
    </script>
</x-app-layout>
