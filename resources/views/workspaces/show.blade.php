<x-app-layout>
    <div class="min-h-screen bg-zinc-950 py-10">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex items-start justify-between mb-10">
                <div>
                    <a href="{{ route('workspaces.index') }}"
                       class="text-sm text-zinc-500 hover:text-white transition">
                        ← Back to Workspaces
                    </a>
                    <h1 class="text-3xl font-black text-white tracking-tighter mt-3">
                        {{ $workspace->name }}
                    </h1>
                    <p class="text-zinc-500 mt-1">
                        {{ $presentations->count() }} presentations
                    </p>
                </div>

                <a href="{{ route('presentations.create', ['workspace' => $workspace->id]) }}"
                   class="bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-xl font-bold transition">
                    + New Presentation
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @forelse($presentations as $p)
                    <div class="bg-zinc-900 rounded-2xl border border-zinc-800 p-6 hover:border-zinc-700 transition">
                        <h2 class="font-bold text-white">
                            {{ $p->title }}
                        </h2>
                        <p class="text-sm text-zinc-500 mt-1 truncate">
                            {{ $p->topic }}
                        </p>

                        <div class="mt-6 flex gap-2">
                            <a href="{{ route('presentations.show', $p) }}"
                               class="flex-1 bg-red-600 hover:bg-red-700 text-white text-center py-2 rounded-lg text-sm font-bold transition">
                                Open
                            </a>
                            <a href="{{ route('presentations.edit', $p) }}"
                               class="flex-1 bg-zinc-950 border border-zinc-800 text-zinc-300 hover:text-white text-center py-2 rounded-lg text-sm font-bold transition">
                                Edit
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-zinc-600 py-20 border border-dashed border-zinc-800 rounded-2xl">
                        <p>No presentations in this workspace</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
