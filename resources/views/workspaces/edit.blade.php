<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10">

        <div class="max-w-2xl mx-auto px-6">

            <div class="mb-6">

                <a href="{{ route('workspaces.show', $workspace) }}"
                   class="text-sm text-gray-500 hover:text-emerald-600">
                    ← Back
                </a>

                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-3">
                    Edit Workspace
                </h1>

            </div>

            @php
                $selected = $workspace->presentations->pluck('id')->toArray();
            @endphp

            <form method="POST" action="{{ route('workspaces.update', $workspace) }}"
                  class="bg-white dark:bg-gray-800 p-6 rounded-2xl border">

                @csrf
                @method('PUT')

                <input type="text"
                       name="name"
                       value="{{ $workspace->name }}"
                       class="w-full mb-6 px-4 py-3 border rounded-xl dark:bg-gray-700 dark:text-white">

                <div class="mb-6">

                    <h3 class="font-semibold mb-3 text-gray-700 dark:text-gray-200">
                        Manage Presentations
                    </h3>

                    <div class="max-h-60 overflow-y-auto border rounded-xl p-4 dark:border-gray-700">

                        @foreach(auth()->user()->presentations as $p)

                            <label class="flex items-center gap-2 mb-2 text-sm">

                                <input type="checkbox"
                                       name="presentations[]"
                                       value="{{ $p->id }}"
                                    @checked(in_array($p->id, $selected))>

                                <span class="text-gray-700 dark:text-gray-300">
                                    {{ $p->title }}
                                </span>

                            </label>

                        @endforeach

                    </div>

                </div>

                <div class="flex gap-3">

                    <button class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl font-semibold">
                        Update
                    </button>

                    <form method="POST" action="{{ route('workspaces.destroy', $workspace) }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                onclick="return confirm('Delete workspace?')"
                                class="px-5 py-3 rounded-xl bg-red-500 text-white font-semibold">
                            Delete
                        </button>

                    </form>

                </div>

            </form>

        </div>

    </div>
</x-app-layout>
