<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-2xl font-black text-white tracking-tighter mb-6">Log in to MIND DRAFT</h2>

    <form method="POST" action="{{ route('login') }}" class="bg-zinc-900 p-8 rounded-2xl border border-zinc-800">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-zinc-300" />
            <x-text-input id="email" class="block mt-1 w-full bg-zinc-950 border-zinc-800 focus:border-red-600 focus:ring-red-600 text-white rounded-xl" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-zinc-300" />
            <x-text-input id="password" class="block mt-1 w-full bg-zinc-950 border-zinc-800 focus:border-red-600 focus:ring-red-600 text-white rounded-xl" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center text-zinc-400">
                <input id="remember_me" type="checkbox" class="rounded border-zinc-700 bg-zinc-950 text-red-600 focus:ring-red-600" name="remember">
                <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-zinc-500 hover:text-white transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif

            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl font-bold transition">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>
