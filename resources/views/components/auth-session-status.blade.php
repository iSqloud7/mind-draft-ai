@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-bold text-sm text-red-500 bg-red-600/10 border border-red-900/50 p-4 rounded-xl mb-6 tracking-wide']) }}>
        {{ $status }}
    </div>
@endif
