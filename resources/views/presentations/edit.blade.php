<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <a href="/presentations/{{ $presentation->id }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-600 mb-3 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back to presentation
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Presentation</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $presentation->title }}</p>
                </div>
                <button form="edit-form" type="submit"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded-xl shadow transition-all hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>

            <form method="POST" action="/presentations/{{ $presentation->id }}" id="edit-form">
                @csrf
                @method('PUT')

                {{-- Title & Topic --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">Presentation Info</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Title</label>
                            <input type="text" name="title" value="{{ $presentation->title }}"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Topic</label>
                            <input type="text" name="topic" value="{{ $presentation->topic }}"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                    </div>
                </div>

                {{-- Slides --}}
                <div id="slides-container" class="space-y-4">
                    @foreach($presentation->structure['slides'] as $index => $slide)
                        <div class="slide-card bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden"
                             data-index="{{ $index }}">

                            {{-- Drag handle + header --}}
                            <div class="flex items-center gap-4 px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700 cursor-grab">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                                <span class="text-sm font-bold text-indigo-500">Slide {{ $index + 1 }}</span>
                                <div class="ml-auto">
                                    <form method="POST" action="/presentations/{{ $presentation->id }}/regenerate-slide/{{ $index }}">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 text-xs font-semibold bg-purple-50 dark:bg-purple-900/30 hover:bg-purple-100 text-purple-600 dark:text-purple-400 px-3 py-1.5 rounded-lg transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Regenerate with AI
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="p-6 space-y-4">
                                {{-- Slide title --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Slide Title</label>
                                    <input type="text"
                                           name="slides[{{ $index }}][title]"
                                           value="{{ $slide['title'] }}"
                                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                </div>

                                {{-- Bullets --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Bullet Points</label>
                                    <div class="space-y-2">
                                        @foreach($slide['bullets'] as $bIndex => $bullet)
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-indigo-400 flex-shrink-0"></span>
                                                <input type="text"
                                                       name="slides[{{ $index }}][bullets][{{ $bIndex }}]"
                                                       value="{{ $bullet }}"
                                                       class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition text-sm">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Notes --}}
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Speaker Notes</label>
                                    <textarea name="slides[{{ $index }}][notes]"
                                              rows="2"
                                              class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-amber-50 dark:bg-amber-900/10 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-400 transition text-sm resize-none">{{ trim($slide['notes']) }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </form>

            {{-- Bottom save --}}
            <div class="mt-6 flex justify-end">
                <button form="edit-form" type="submit"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-8 py-3 rounded-xl shadow transition-all hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
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
                    card.querySelector('.text-indigo-500').textContent = `Slide ${index + 1}`;
                });
            }
        });
    </script>
</x-app-layout>
