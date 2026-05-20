<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <div class="flex items-center justify-between mb-10">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white tracking-tight">
                        My Presentations
                    </h1>
                    <p class="mt-1 text-gray-500 dark:text-gray-400">
                        {{ $presentations->count() }} presentation{{ $presentations->count() !== 1 ? 's' : '' }} created
                    </p>
                </div>
                <a href="/presentations/create"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl shadow-md transition-all duration-200 hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Presentation
                </a>
            </div>

            @if($presentations->isEmpty())
                <div class="flex flex-col items-center justify-center py-32 text-center">
                    <div class="bg-indigo-50 dark:bg-indigo-900/30 rounded-full p-6 mb-6">
                        <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">No presentations yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-8">Create your first AI-powered presentation in seconds.</p>
                    <a href="/presentations/create"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-xl shadow transition-all duration-200 hover:scale-105">
                        Create your first presentation
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($presentations as $p)
                        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:border-indigo-200 dark:hover:border-indigo-500 transition-all duration-300 flex flex-col">
                            <div class="h-2 rounded-t-2xl bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                            <div class="p-6 flex flex-col flex-1">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs font-semibold bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-300 px-3 py-1 rounded-full">
                                        {{ count($p->structure['slides'] ?? []) }} slides
                                    </span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ $p->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2">
                                    {{ $p->title }}
                                </h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 line-clamp-2">
                                    {{ $p->topic }}
                                </p>
                                <div class="mt-auto flex items-center gap-2">
                                    <a href="/presentations/{{ $p->id }}"
                                       class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 rounded-lg transition-colors">
                                        Open
                                    </a>
                                    <a href="/presentations/{{ $p->id }}/edit"
                                       class="flex-1 text-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-semibold py-2 rounded-lg transition-colors">
                                        Edit
                                    </a>
                                    <form method="POST" action="/presentations/{{ $p->id }}" onsubmit="return confirm('Delete this presentation?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 text-red-500 dark:text-red-400 p-2 rounded-lg transition-colors">
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
