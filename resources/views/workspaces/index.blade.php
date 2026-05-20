<x-app-layout>
    <div class="min-h-screen bg-zinc-950 py-10">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex items-center justify-between mb-10">
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tighter">
                        Workspaces
                    </h1>
                    <p class="text-zinc-500 mt-1">
                        {{ $workspaces->count() }} active workspace(s)
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ url()->previous() }}"
                       class="text-zinc-500 hover:text-white text-sm font-semibold transition">
                        ← Back
                    </a>
                    <a href="{{ route('workspaces.create') }}"
                       class="bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-xl font-bold transition">
                        + New Workspace
                    </a>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @foreach($workspaces as $workspace)
                    <div class="bg-zinc-900 rounded-2xl border border-zinc-800 overflow-hidden hover:border-zinc-700 transition">

                        <div class="h-2 bg-gradient-to-r from-red-600 to-red-500"></div>

                        <div class="p-6">
                            <h2 class="text-lg font-bold text-white">
                                {{ $workspace->name }}
                            </h2>
                            <p class="text-sm text-zinc-500 mt-1">
                                {{ $workspace->presentations_count }} presentations
                            </p>

                            <div class="mt-6 flex gap-2">
                                <a href="{{ route('workspaces.show', $workspace) }}"
                                   class="flex-1 text-center bg-zinc-800 hover:bg-zinc-700 text-white py-2 rounded-lg text-sm font-bold transition">
                                    Open
                                </a>
                                <a href="{{ route('workspaces.edit', $workspace) }}"
                                   class="flex-1 text-center bg-zinc-950 border border-zinc-800 text-zinc-300 py-2 rounded-lg text-sm font-bold hover:text-white transition">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
