<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body
    class="font-sans text-gray-900 antialiased bg-gradient-to-br from-indigo-600 via-blue-600 to-sky-500 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-xl">
            <div class="bg-white/95 backdrop-blur-sm border border-white/40 shadow-2xl rounded-2xl p-8 sm:p-10">
                <div class="space-y-6">
                    <x-ui.flash-messages />

                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
