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
<body class="font-sans antialiased bg-black text-zinc-200">
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-8 sm:pt-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-zinc-900 via-black to-black px-4">
    <div class="mb-8 transition-transform duration-300 hover:scale-105">
        <a href="/" class="flex flex-col items-center gap-2">
            <x-application-logo class="w-16 h-16 fill-current text-red-600" />
            <span class="text-2xl font-black tracking-widest text-white uppercase mt-2">MIND <span class="text-red-600">DRAFT AI</span></span>
        </a>
    </div>
    <div class="w-full sm:max-w-md mt-4 px-8 py-10 bg-zinc-950 border border-zinc-900 rounded-2xl shadow-[0_10px_50px_rgba(0,0,0,0.8)]">
        {{ $slot }}
    </div>
</div>
</body>
</html>
