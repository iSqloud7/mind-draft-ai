<x-app-layout>
    <div class="min-h-screen bg-black text-white py-12">
        <div class="max-w-4xl mx-auto px-6 sm:px-8 lg:px-10">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12 gap-6 pb-8 border-b border-zinc-900">
                <div>
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-red-500 transition-colors font-bold uppercase tracking-wider">
                        ← Back to Dashboard
                    </a>
                    <h1 class="text-3xl md:text-4xl font-black text-white mt-4 uppercase tracking-tight break-words">
                        {{ $presentation->title }}
                    </h1>
                    <p class="mt-2 text-zinc-500 font-medium tracking-wide">
                        {{ count($presentation->structure['slides'] ?? []) }} slides available in this draft
                    </p>
                </div>

                {{-- ACTIONS --}}
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <a href="{{ route('presentations.edit', $presentation) }}"
                       class="flex-1 md:flex-none text-center bg-zinc-950 hover:bg-zinc-900 border border-zinc-800 text-zinc-300 hover:text-white px-5 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition duration-200">
                        Edit
                    </a>

                    <a href="{{ route('presentations.present', $presentation) }}"
                       class="flex-1 md:flex-none text-center bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest shadow-[0_4px_20px_rgba(220,38,38,0.25)] transition duration-200 hover:scale-[1.02]">
                        Present
                    </a>

                    <form method="POST"
                          action="{{ route('presentations.destroy', $presentation) }}"
                          onsubmit="return confirm('Delete presentation?')"
                          class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="bg-zinc-950 hover:bg-red-950/40 border border-zinc-800 hover:border-red-900/30 px-4 py-3 rounded-xl text-zinc-500 hover:text-red-500 transition duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- WORKSPACE SECTION --}}
            <div class="mb-10 bg-zinc-950 border border-zinc-900 rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-black text-zinc-500 uppercase tracking-widest">
                        Workspace Assignment
                    </h3>
                    @if($presentation->workspace)
                        <span class="text-[10px] font-black bg-red-600/10 text-red-500 border border-red-900/40 px-3 py-1 rounded-md uppercase tracking-wider">
                            {{ $presentation->workspace->name }}
                        </span>
                    @else
                        <span class="text-[10px] text-zinc-600 font-bold uppercase tracking-widest">
                            No workspace assigned
                        </span>
                    @endif
                </div>

                <form method="POST" action="{{ route('presentations.updateWorkspace', $presentation) }}">
                    @csrf
                    @method('PATCH')
                    <div class="flex gap-3">
                        <select name="workspace_id"
                                class="flex-1 px-4 py-3.5 border border-zinc-900 rounded-xl bg-zinc-950 text-white focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 text-sm font-semibold transition outline-none">
                            <option value="" class="bg-zinc-950">No workspace</option>
                            @foreach(auth()->user()->workspaces as $workspace)
                                <option value="{{ $workspace->id }}" @selected($presentation->workspace_id == $workspace->id) class="bg-zinc-950">
                                    {{ $workspace->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                                class="bg-zinc-900 hover:bg-red-600 border border-zinc-800 hover:border-red-600 text-white px-6 py-3.5 rounded-xl text-xs font-black uppercase tracking-widest transition duration-200">
                            Save
                        </button>
                    </div>
                </form>
            </div>

            {{-- SLIDES --}}
            <div class="space-y-6">
                @foreach($presentation->structure['slides'] as $index => $slide)
                    <div class="bg-zinc-950 rounded-2xl border border-zinc-900 overflow-hidden shadow-xl">

                        {{-- Slide Header --}}
                        <div class="flex items-center gap-4 px-6 py-4 bg-zinc-900/40 border-b border-zinc-900">
                            <span class="w-8 h-8 rounded-full bg-red-600/10 text-red-500 border border-red-900/40 flex items-center justify-center font-black text-xs shadow-[0_0_10px_rgba(220,38,38,0.1)]">
                                {{ $index + 1 }}
                            </span>
                            <h2 class="text-lg font-bold text-white uppercase tracking-tight break-words">
                                {{ $slide['title'] }}
                            </h2>
                        </div>

                        {{-- Slide Content --}}
                        <div class="p-8">
                            <ul class="space-y-4 mb-6">
                                @foreach($slide['bullets'] as $bullet)
                                    <li class="flex items-start gap-3">
                                        <span class="w-2 h-2 mt-2 rounded-full bg-red-600 flex-shrink-0 shadow-[0_0_8px_rgba(220,38,38,0.8)]"></span>
                                        <span class="text-zinc-300 text-sm font-medium leading-relaxed break-words">
                                            {{ $bullet }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>

                            @if(!empty($slide['notes']))
                                <div class="bg-zinc-900/30 border border-zinc-900 rounded-xl p-5 mt-6">
                                    <p class="text-xs font-black text-zinc-500 uppercase tracking-widest mb-2">
                                        Speaker Notes
                                    </p>
                                    <p class="text-sm text-zinc-400 font-medium leading-relaxed break-words">
                                        {{ $slide['notes'] }}
                                    </p>
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
