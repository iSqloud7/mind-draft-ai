<x-app-layout>
    <div class="min-h-screen bg-zinc-950 py-10">
        <div class="max-w-4xl mx-auto px-6 space-y-6">

            <div class="mb-8">
                <h1 class="text-3xl font-black text-white tracking-tighter">Profile Settings</h1>
                <p class="text-zinc-500 mt-1">Manage your account information and security.</p>
            </div>

            <div class="p-6 sm:p-8 bg-zinc-900 border border-zinc-800 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-zinc-900 border border-zinc-800 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-zinc-900 border border-zinc-800 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
