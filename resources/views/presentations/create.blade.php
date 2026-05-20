<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-2xl">

            {{-- Back --}}
            <a href="/dashboard" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-600 mb-8 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Dashboard
            </a>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">

                {{-- Header --}}
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="bg-indigo-100 dark:bg-indigo-900/50 rounded-xl p-2">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Generate Presentation</h1>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400">Fill in the details and AI will create your slides instantly.</p>
                </div>

                <form method="POST" action="/presentations" id="generate-form">
                    @csrf

                    {{-- Title --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Presentation Title
                        </label>
                        <input type="text" name="title"
                               value="{{ old('title') }}"
                               placeholder="e.g. The Future of Artificial Intelligence"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Topic --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Main Topic
                        </label>
                        <input type="text" name="topic"
                               value="{{ old('topic') }}"
                               placeholder="e.g. Machine Learning in Healthcare"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        @error('topic')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Key Points --}}
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Key Points
                            <span class="font-normal text-gray-400">(up to 5)</span>
                        </label>
                        <div class="space-y-3" id="points-container">
                            @for($i = 0; $i < 3; $i++)
                                <div class="flex items-center gap-2 point-row">
                                    <span class="text-xs font-bold text-indigo-400 w-6 text-center">{{ $i + 1 }}</span>
                                    <input type="text" name="points[]"
                                           value="{{ old('points.'.$i) }}"
                                           placeholder="Key point {{ $i + 1 }}"
                                           class="flex-1 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                    @if($i >= 1)
                                        <button type="button" onclick="removePoint(this)"
                                                class="text-gray-300 hover:text-red-400 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    @else
                                        <div class="w-5"></div>
                                    @endif
                                </div>
                            @endfor
                        </div>

                        <button type="button" onclick="addPoint()"
                                class="mt-3 inline-flex items-center gap-1 text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add another point
                        </button>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" id="submit-btn"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-md transition-all duration-200 hover:scale-[1.02] flex items-center justify-center gap-3">
                        <svg id="btn-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span id="btn-text">Generate with AI</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let pointCount = 3;

        function addPoint() {
            if (pointCount >= 5) return;
            pointCount++;
            const container = document.getElementById('points-container');
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 point-row';
            div.innerHTML = `
                <span class="text-xs font-bold text-indigo-400 w-6 text-center">${pointCount}</span>
                <input type="text" name="points[]" placeholder="Key point ${pointCount}"
                       class="flex-1 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                <button type="button" onclick="removePoint(this)" class="text-gray-300 hover:text-red-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>`;
            container.appendChild(div);
        }

        function removePoint(btn) {
            btn.closest('.point-row').remove();
            pointCount--;
            reindexPoints();
        }

        function reindexPoints() {
            document.querySelectorAll('.point-row').forEach((row, i) => {
                row.querySelector('span').textContent = i + 1;
                const input = row.querySelector('input');
                input.placeholder = `Key point ${i + 1}`;
            });
            pointCount = document.querySelectorAll('.point-row').length;
        }

        document.getElementById('generate-form').addEventListener('submit', function() {
            const btn = document.getElementById('submit-btn');
            const text = document.getElementById('btn-text');
            btn.disabled = true;
            btn.classList.add('opacity-75');
            text.textContent = 'Generating...';
        });
    </script>
</x-app-layout>
