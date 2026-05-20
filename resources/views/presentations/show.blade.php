<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            {{-- Header --}}
            <div class="flex items-start justify-between mb-10">
                <div>
                    <a href="/dashboard" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-600 mb-4 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Dashboard
                    </a>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white tracking-tight">
                        {{ $presentation->title }}
                    </h1>
                    <p class="mt-2 text-gray-500 dark:text-gray-400 text-lg">
                        {{ $presentation->topic }}
                    </p>
                </div>

                {{-- Action buttons --}}
                <div class="flex items-center gap-2 flex-shrink-0 ml-6">
                    <a href="/presentations/{{ $presentation->id }}/edit"
                       class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-indigo-400 text-gray-700 dark:text-gray-200 font-semibold px-4 py-2 rounded-xl transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    <a href="/presentations/{{ $presentation->id }}/present"
                       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-xl transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Present
                    </a>
                    <form method="POST" action="/presentations/{{ $presentation->id }}" onsubmit="return confirm('Delete this presentation?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-red-400 hover:text-red-500 text-gray-500 font-semibold px-4 py-2 rounded-xl transition-all text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            {{-- Slides --}}
            @foreach($presentation->structure['slides'] as $index => $slide)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 mb-6 overflow-hidden hover:shadow-md transition-shadow">

                    {{-- Slide header --}}
                    <div class="flex items-center gap-4 px-8 pt-6 pb-4 border-b border-gray-50 dark:border-gray-700/50">
                        <span class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 text-sm font-bold flex items-center justify-center">
                            {{ $index + 1 }}
                        </span>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ $slide['title'] }}
                        </h2>
                    </div>

                    <div class="px-8 py-6">
                        {{-- Bullets --}}
                        <ul class="space-y-3 mb-6">
                            @foreach($slide['bullets'] as $bullet)
                                <li class="flex items-start gap-3">
                                    <span class="mt-1.5 flex-shrink-0 w-2 h-2 rounded-full bg-indigo-500"></span>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $bullet }}</span>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Notes --}}
                        @if(!empty($slide['notes']))
                            <div class="flex items-start gap-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800/30 rounded-xl p-4">
                                <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-semibold text-amber-700 dark:text-amber-400 uppercase tracking-wide mb-1">Speaker Notes</p>
                                    <p class="text-sm text-amber-800 dark:text-amber-300">{{ $slide['notes'] }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>
