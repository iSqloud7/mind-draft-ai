<nav x-data="{ open: false }" class="bg-zinc-950 border-b border-zinc-900 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="flex justify-between h-20">
            <div class="flex font-semibold">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <x-application-logo class="block h-9 w-auto fill-current text-red-600 transition-colors" />
                        <span class="text-lg font-black tracking-tighter text-white uppercase">MIND<span class="text-red-600">DRAFT</span></span>
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-12 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('presentations.index')" :active="request()->routeIs('presentations.*')">
                        {{ __('My Presentations') }}
                    </x-nav-link>
                    <x-nav-link :href="route('workspaces.index')" :active="request()->routeIs('workspaces.*')">
                        {{ __('My Workspaces') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                    <button @click="dropdownOpen = !dropdownOpen" class="inline-flex items-center px-4 py-2.5 border border-zinc-800 text-sm font-medium rounded-xl text-zinc-400 bg-zinc-900/50 hover:text-white hover:bg-zinc-900 hover:border-zinc-700 focus:outline-none transition ease-in-out duration-150">
                        <div class="font-bold tracking-wide">{{ Auth::user()->name }}</div>
                        <div class="ms-2 text-zinc-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="dropdownOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 w-48 mt-2 rounded-xl border border-zinc-900 bg-zinc-950 py-2 shadow-2xl z-50"
                         style="display: none;">

                        <a href="{{ route('profile.edit') }}" class="block w-full px-4 py-2.5 text-start text-sm font-bold text-zinc-300 hover:text-white hover:bg-red-600/10 transition duration-150 ease-in-out">
                            {{ __('Profile') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2.5 text-start text-sm font-bold text-red-500 hover:bg-red-600/10 transition duration-150 ease-in-out">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-xl text-zinc-500 hover:text-white hover:bg-zinc-900 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-zinc-950 border-t border-zinc-900">
        <div class="pt-3 pb-4 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-nav-link :href="route('presentations.index')" :active="request()->routeIs('presentations.*')">
                {{ __('My Presentations') }}
            </x-nav-link>
            <x-nav-link :href="route('workspaces.index')" :active="request()->routeIs('workspaces.*')">
                {{ __('My Workspaces') }}
            </x-nav-link>
        </div>
        <div class="pt-4 pb-4 border-t border-zinc-900 bg-zinc-900/20 px-6">
            <div class="px-2 mb-3">
                <div class="font-bold text-base text-white tracking-wide">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-zinc-500 mt-0.5">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="text-red-500 hover:bg-red-950/30" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
