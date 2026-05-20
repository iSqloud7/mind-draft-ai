<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">

        <h1 class="text-4xl font-bold mb-2">
            {{ $presentation->title }}
        </h1>

        <a href="/presentations/{{ $presentation->id }}/edit">
            Edit Presentation
        </a>

        <p class="text-gray-500 mb-10">
            {{ $presentation->topic }}
        </p>

        @foreach($presentation->structure['slides'] as $index => $slide)
            <div class="bg-white rounded-xl shadow p-8 mb-8">
                <p class="text-sm text-gray-400">
                    Slide {{ $index + 1 }}
                </p>

                <h2 class="text-2xl font-bold mb-4">
                    {{ $slide['title'] }}
                </h2>

                <ul class="list-disc ml-6 space-y-2">
                    @foreach($slide['bullets'] as $bullet)
                        <li>{{ $bullet }}</li>
                    @endforeach
                </ul>

                <div class="mt-6 p-4 bg-gray-100 rounded">
                    <strong>Speaker Notes:</strong>
                    <p>{{ $slide['notes'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <a href="/presentations/{{ $presentation->id }}/export-pdf">
        Export PDF
    </a>
    <a href="/presentations/{{ $presentation->id }}/present">
        Present Mode
    </a>
</x-app-layout>

