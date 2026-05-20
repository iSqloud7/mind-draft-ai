<x-guest-layout>
    <h2 class="text-2xl font-black text-white tracking-tighter mb-6">Create your account</h2>

    <form method="POST" action="{{ route('register') }}" class="bg-zinc-900 p-8 rounded-2xl border border-zinc-800">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-zinc-300" />
            <x-text-input id="name" class="block mt-1 w-full bg-zinc-950 border-zinc-800 focus:border-red-600 focus:ring-red-600 text-white rounded-xl" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-zinc-300" />
            <x-text-input id="email" class="block mt-1 w-full bg-zinc-950 border-zinc-800 focus:border-red-600 focus:ring-red-600 text-white rounded-xl" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-zinc-300" />
            <x-text-input id="password" class="block mt-1 w-full bg-zinc-950 border-zinc-800 focus:border-red-600 focus:ring-red-600 text-white rounded-xl" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-zinc-300" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-zinc-950 border-zinc-800 focus:border-red-600 focus:ring-red-600 text-white rounded-xl" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-zinc-500 hover:text-white transition" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl font-bold transition">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>
