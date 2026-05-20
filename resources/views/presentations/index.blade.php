<x-app-layout>
    <div class="max-w-6xl mx-auto py-10">

        <div class="flex justify-between mb-8">
            <h1 class="text-3xl font-bold">My Presentations</h1>

            <a href="{{ route('presentations.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                New Presentation
            </a>
        </div>

        <div class="grid grid-cols-3 gap-6">
            @foreach($presentations as $presentation)
                <div class="shadow rounded p-6 bg-white">
                    <h2 class="font-bold text-xl">
                        {{ $presentation->title }}
                    </h2>

                    <p class="text-gray-500">
                        {{ $presentation->topic }}
                    </p>

                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('presentations.show', $presentation) }}">
                            View
                        </a>

                        <a href="{{ route('presentations.edit', $presentation) }}">
                            Edit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
