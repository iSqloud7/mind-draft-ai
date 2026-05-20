<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10">

        <div class="max-w-7xl mx-auto px-6">

            <div class="flex items-center justify-between mb-10">

                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">
                        Workspaces
                    </h1>
                    <p class="text-gray-500 mt-1">
                        {{ $workspaces->count() }} workspace(s)
                    </p>
                </div>

                <div class="flex items-center gap-3">

                    <a href="{{ url()->previous() }}"
                       class="text-gray-500 hover:text-emerald-600 text-sm font-semibold">
                        ← Back
                    </a>

                    <a href="{{ route('workspaces.create') }}"
                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-xl font-semibold">
                        + New Workspace
                    </a>

                </div>

            </div>

            <div class="grid md:grid-cols-3 gap-6">

                @foreach($workspaces as $workspace)

                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">

                        <div class="h-2 bg-gradient-to-r from-emerald-500 to-green-500"></div>

                        <div class="p-6">

                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $workspace->name }}
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ $workspace->presentations_count }} presentations
                            </p>

                            <div class="mt-6 flex gap-2">

                                <a href="{{ route('workspaces.show', $workspace) }}"
                                   class="flex-1 text-center bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg text-sm font-semibold">
                                    Open
                                </a>

                                <a href="{{ route('workspaces.edit', $workspace) }}"
                                   class="flex-1 text-center bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 py-2 rounded-lg text-sm font-semibold">
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
