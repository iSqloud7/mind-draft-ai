<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10">

        <div class="max-w-7xl mx-auto px-6">

            <div class="flex items-start justify-between mb-10">

                <div>

                    <a href="{{ route('workspaces.index') }}"
                       class="text-sm text-gray-500 hover:text-emerald-600">
                        ← Back to Workspaces
                    </a>

                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-3">
                        {{ $workspace->name }}
                    </h1>

                    <p class="text-gray-500 mt-1">
                        {{ $presentations->count() }} presentations
                    </p>

                </div>

                <a href="{{ route('presentations.create', ['workspace' => $workspace->id]) }}"
                   class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl font-semibold">
                    + New Presentation
                </a>

            </div>

            <div class="grid md:grid-cols-3 gap-6">

                @forelse($presentations as $p)

                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6">

                        <h2 class="font-bold text-gray-900 dark:text-white">
                            {{ $p->title }}
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $p->topic }}
                        </p>

                        <div class="mt-4 flex gap-2">

                            <a href="{{ route('presentations.show', $p) }}"
                               class="flex-1 bg-emerald-600 text-white text-center py-2 rounded-lg text-sm font-semibold">
                                Open
                            </a>

                            <a href="{{ route('presentations.edit', $p) }}"
                               class="flex-1 bg-gray-100 dark:bg-gray-700 text-center py-2 rounded-lg text-sm font-semibold">
                                Edit
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="col-span-3 text-center text-gray-500 py-20">
                        No presentations in this workspace
                    </div>

                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>
