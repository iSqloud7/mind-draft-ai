<x-app-layout>
    <div class="min-h-screen bg-zinc-950 py-10">
        <div class="max-w-2xl mx-auto px-6">

            <div class="mb-8">
                <a href="{{ route('workspaces.show', $workspace) }}" class="text-sm text-zinc-500 hover:text-white transition">
                    ← Back to Workspace
                </a>
                <h1 class="text-3xl font-black text-white tracking-tighter mt-3">Edit Workspace</h1>
            </div>

            <form action="{{ route('workspaces.update', $workspace) }}" method="POST" class="bg-zinc-900 p-8 rounded-2xl border border-zinc-800">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-sm font-bold text-zinc-300 mb-2">Workspace Name</label>
                    <input type="text" name="name" value="{{ old('name', $workspace->name) }}" required
                           class="w-full bg-zinc-950 border border-zinc-800 text-white rounded-xl px-4 py-3 focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition">
                </div>

                <div class="mb-8">
                    <h3 class="font-bold text-zinc-300 mb-4">Manage Presentations</h3>

                    <div class="max-h-60 overflow-y-auto border border-zinc-800 rounded-xl p-4 bg-zinc-950">
                        @foreach(auth()->user()->presentations as $p)
                            <label class="flex items-center gap-3 mb-3 text-sm text-zinc-300 hover:text-white cursor-pointer">
                                <input type="checkbox"
                                       name="presentations[]"
                                       value="{{ $p->id }}"
                                       @checked($p->workspace_id == $workspace->id)
                                       class="rounded border-zinc-700 bg-zinc-900 text-red-600 focus:ring-red-600">
                                {{ $p->title }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition">
                    Save Changes
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
