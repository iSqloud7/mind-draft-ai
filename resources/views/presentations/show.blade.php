<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10">

        <div class="max-w-4xl mx-auto px-6">

            {{-- HEADER --}}
            <div class="flex items-start justify-between mb-10">

                <div>

                    <a href="{{ route('dashboard') }}"
                       class="text-sm text-gray-500 hover:text-emerald-600 transition">
                        ← Back to Dashboard
                    </a>

                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mt-3">
                        {{ $presentation->title }}
                    </h1>

                    <p class="text-gray-500 mt-2 text-lg">
                        {{ $presentation->topic }}
                    </p>

                </div>

                {{-- ACTIONS --}}
                <div class="flex items-center gap-2">

                    <a href="{{ route('presentations.edit', $presentation) }}"
                       class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200">
                        Edit
                    </a>

                    <a href="{{ route('presentations.present', $presentation) }}"
                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-semibold">
                        Present
                    </a>

                    <form method="POST"
                          action="{{ route('presentations.destroy', $presentation) }}"
                          onsubmit="return confirm('Delete presentation?')">

                        @csrf
                        @method('DELETE')

                        <button class="bg-white dark:bg-gray-800 border px-4 py-2 rounded-xl text-sm text-red-500 hover:text-red-600">
                            Delete
                        </button>

                    </form>

                </div>

            </div>

            {{-- WORKSPACE SECTION --}}
            <div class="mb-8 bg-white dark:bg-gray-800 border rounded-2xl p-5">

                <div class="flex items-center justify-between mb-3">

                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Workspace
                    </h3>

                    @if($presentation->workspace)
                        <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full">
                            {{ $presentation->workspace->name }}
                        </span>
                    @else
                        <span class="text-xs text-gray-400">
                            No workspace assigned
                        </span>
                    @endif

                </div>

                <form method="POST"
                      action="{{ route('presentations.updateWorkspace', $presentation) }}">

                    @csrf
                    @method('PATCH')

                    <div class="flex gap-3">

                        <select name="workspace_id"
                                class="flex-1 px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">

                            <option value="">No workspace</option>

                            @foreach(auth()->user()->workspaces as $workspace)
                                <option value="{{ $workspace->id }}"
                                    @selected($presentation->workspace_id == $workspace->id)>
                                    {{ $workspace->name }}
                                </option>
                            @endforeach

                        </select>

                        <button type="submit"
                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                            Save
                        </button>

                    </div>

                </form>

            </div>

            {{-- SLIDES --}}
            @foreach($presentation->structure['slides'] as $index => $slide)

                <div class="bg-white dark:bg-gray-800 rounded-2xl border mb-6 overflow-hidden">

                    <div class="flex items-center gap-4 px-6 py-4 border-b">

                        <span class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 flex items-center justify-center font-bold">
                            {{ $index + 1 }}
                        </span>

                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $slide['title'] }}
                        </h2>

                    </div>

                    <div class="px-6 py-5">

                        <ul class="space-y-3 mb-5">
                            @foreach($slide['bullets'] as $bullet)
                                <li class="flex gap-3">
                                    <span class="w-2 h-2 mt-2 bg-emerald-500 rounded-full"></span>
                                    <span class="text-gray-700 dark:text-gray-300">
                                        {{ $bullet }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        @if(!empty($slide['notes']))
                            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl p-4">

                                <p class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 mb-1">
                                    Notes
                                </p>

                                <p class="text-sm text-emerald-800 dark:text-emerald-300">
                                    {{ $slide['notes'] }}
                                </p>

                            </div>
                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    </div>
</x-app-layout>
