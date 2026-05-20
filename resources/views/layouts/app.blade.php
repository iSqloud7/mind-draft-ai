<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-black text-zinc-100">
<div class="min-h-screen bg-black flex flex-col">
    @include('layouts.navigation')

    @isset($header)
        <header class="bg-zinc-950 border-b border-zinc-900">
            <div class="max-w-7xl mx-auto py-8 px-6 sm:px-8 lg:px-10">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main class="flex-1 py-12">
        {{ $slot }}
    </main>
</div>
</body>
</html>
