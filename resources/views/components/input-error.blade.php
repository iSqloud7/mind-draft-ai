@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-xs font-bold text-red-500 space-y-1 mt-2 tracking-wide']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center gap-1">
                <span>⚠️</span> {{ $message }}
            </li>
        @endforeach
    </ul>
@endif
