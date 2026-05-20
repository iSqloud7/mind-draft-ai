<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10">

        <div class="max-w-2xl mx-auto px-6">

            <div class="mb-6">

                <a href="{{ route('workspaces.index') }}"
                   class="text-sm text-gray-500 hover:text-emerald-600">
                    ← Back
                </a>

                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-3">
                    Create Workspace
                </h1>

            </div>

            <form method="POST" action="{{ route('workspaces.store') }}"
                  class="bg-white dark:bg-gray-800 p-6 rounded-2xl border">

                @csrf

                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Workspace name"
                       class="w-full mb-6 px-4 py-3 border rounded-xl dark:bg-gray-700 dark:text-white">

                <div class="mb-6">

                    <h3 class="font-semibold mb-3 text-gray-700 dark:text-gray-200">
                        Add Presentations (optional)
                    </h3>

                    <div class="max-h-60 overflow-y-auto border rounded-xl p-4 dark:border-gray-700">

                        @foreach(auth()->user()->presentations as $p)

                            <label class="flex items-center gap-2 mb-2 text-sm text-gray-700 dark:text-gray-300">

                                <input type="checkbox" name="presentations[]" value="{{ $p->id }}">

                                {{ $p->title }}

                            </label>

                        @endforeach

                    </div>

                </div>

                <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl font-semibold">
                    Create Workspace
                </button>

            </form>

        </div>

    </div>
</x-app-layout>
