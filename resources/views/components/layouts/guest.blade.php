<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>


    </head>
    <body class="h-screen bg-gray-100 flex items-center justify-center">
        <div class="bg-white w-full max-w-4xl flex flex-col md:flex-row shadow-lg rounded-lg overflow-hidden">
            <div class="w-full md:w-1/2 bg-blue-400 order-1 md:order-2">
                <img src="images/NRNBUILDING.png" alt="Login Image" class="w-full h-full object-cover">
            </div>
            <div class="w-full md:w-1/2 p-8 order-2 md:order-1">
                <a wire:navigate href="{{route('welcome')}}" class="inline-flex items-center text-blue-500 hover:text-blue-700 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Return Home
                </a>
                {{ $slot }}
            </div>
        </div>
        @livewireScripts

    </body>
</html>