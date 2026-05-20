<x-app-layout>
    <div class="min-h-screen bg-black text-white flex items-center justify-center py-16 px-4">
        <div class="w-full max-w-2xl">

            <a href="/dashboard" class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-red-500 mb-8 transition-colors font-bold uppercase tracking-wider">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Dashboard
            </a>

            <div class="bg-zinc-950 rounded-2xl shadow-[0_10px_50px_rgba(0,0,0,0.8)] border border-zinc-900 p-8 sm:p-10">

                <div class="mb-10">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="bg-red-600/10 border border-red-600/20 rounded-xl p-3 text-red-600 shadow-[0_0_15px_rgba(220,38,38,0.15)]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-black text-white uppercase tracking-tight">Generate Presentation</h1>
                    </div>
                    <p class="text-zinc-500 font-medium tracking-wide">Fill in the details and AI will create your slides instantly.</p>
                </div>

                <form method="POST" action="/presentations" id="generate-form" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-zinc-400 mb-2">
                            Presentation Title
                        </label>
                        <input type="text" name="title"
                               value="{{ old('title') }}"
                               placeholder="example: The Future of Artificial Intelligence."
                               class="w-full px-4 py-3.5 rounded-xl border border-zinc-900 bg-zinc-950 text-white placeholder-zinc-700 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200 outline-none">
                        @error('title')
                        <p class="mt-2 text-xs font-bold text-red-500 tracking-wide">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-zinc-400 mb-2">
                            Main Topic
                        </label>
                        <input type="text" name="topic"
                               value="{{ old('topic') }}"
                               placeholder="example: Machine Learning in Healthcare."
                               class="w-full px-4 py-3.5 rounded-xl border border-zinc-900 bg-zinc-950 text-white placeholder-zinc-700 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200 outline-none">
                        @error('topic')
                        <p class="mt-2 text-xs font-bold text-red-500 tracking-wide">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-zinc-400 mb-3">
                            Key Points
                            <span class="font-bold text-zinc-600 lowercase">(up to 7)</span>
                        </label>

                        <div class="space-y-3.5" id="points-container">
                            @for($i = 0; $i < 3; $i++)
                                <div class="flex items-center gap-3 point-row">
                                    <span class="text-xs font-black text-red-600 w-6 text-center">{{ $i + 1 }}</span>
                                    <input type="text" name="points[]"
                                           value="{{ old('points.'.$i) }}"
                                           placeholder="Key point {{ $i + 1 }}."
                                           class="flex-1 px-4 py-3.5 rounded-xl border border-zinc-900 bg-zinc-950 text-white placeholder-zinc-700 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200 outline-none">
                                    @if($i >= 1)
                                        <button type="button" onclick="removePoint(this)"
                                                class="text-zinc-600 hover:text-red-500 transition-colors p-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    @else
                                        <div class="w-7"></div>
                                    @endif
                                </div>
                            @endfor
                        </div>

                        <button type="button" onclick="addPoint()"
                                class="mt-4 inline-flex items-center gap-1.5 text-xs font-black text-red-500 hover:text-red-400 uppercase tracking-widest transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add another point
                        </button>
                    </div>

                    <div class="pt-4">
                        <button type="submit" id="submit-btn"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-xl shadow-[0_4px_25px_rgba(220,38,38,0.2)] hover:scale-[1.01] active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-3 uppercase tracking-widest text-xs">
                            <svg id="btn-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span id="btn-text">Generate with AI</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let pointCount = 3;

        function addPoint() {
            if (pointCount >= 7) return;
            pointCount++;
            const container = document.getElementById('points-container');
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3 point-row';
            div.innerHTML = `
                <span class="text-xs font-black text-red-600 w-6 text-center">${pointCount}</span>
                <input type="text" name="points[]" placeholder="Key point ${pointCount}"
                       class="flex-1 px-4 py-3.5 rounded-xl border border-zinc-900 bg-zinc-950 text-white placeholder-zinc-700 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition duration-200 outline-none">
                <button type="button" onclick="removePoint(this)" class="text-zinc-600 hover:text-red-500 transition-colors p-1">
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
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            text.textContent = 'Generating with AI...';
        });
    </script>
</x-app-layout>
