<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
  <!-- Primary Navigation Menu -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
          <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                  <a href="{{ route('dashboard') }}">
                      <x-application-logo class="block h-9 w-20 fill-current text-gray-800" />
                  </a>
              </div>
          </div>
      </div>
  </div>
</nav>
  @if (Route::has('login'))
      <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
          @auth
              <a href="{{ url('/home') }}" class="ml-4 font-semibold text-gray-600 hover:text-blue-900 text-gray-400 hover:text-green focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
          @else
              <a href="{{ route('login') }}" class="ml-4 font-semibold text-gray-600 hover:text-blue-900 text-gray-400 hover:text-green focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

              @if (Route::has('register'))
                  <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-blue-900 text-gray-400 hover:text-green focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
              @endif
          @endauth
      </div>
  @endif
</body>
</html>