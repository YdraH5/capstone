<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>NRN Building</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

      <!-- Scripts -->
      <script src="https://cdn.tailwindcss.com"></script>
      @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  
<nav x-data="{ open: false }" class="bg-white border-b border-gray-300">
  <!-- Primary Navigation Menu -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
          <div class="flex">
              <!-- Logo -->
              <div class="logo shrink-0 flex items-center">
                  <a href="{{ route('welcome') }}">
                      <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                  </a>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link  :href="route('available')" :active="request()->routeIs('available')">
                  {{ __('Available') }}
                </x-nav-link>
              </div>
              {{--container for login and register  --}}
          <div class="inline-flex absolute top-4 right-2 space-x-reverse space-y-0 ">
            
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                  {{-- for search box --}}
                  <form action="/search" class="max-w-[480px] w-full px-4">
                      @csrf
                      @include('buttons.search')
                  </form>
                </div>
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex ">
                  <x-nav-link  :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                  </x-nav-link>
                </div>
            </div>
          </div>
          <div class="-me-2 flex items-center sm:hidden">
            @include('buttons.search')
            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
          </div> 
      </div> 
  </div>
  <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
      
        <x-responsive-nav-link   :href="route('available')" :active="request()->routeIs('available')">
        {{ __('Available') }}
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('auth.login')">
            {{ __('Login') }}
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('auth.register')">
          {{ __('Register') }}
        </x-responsive-nav-link>

    </div>
  </div>


</nav>

</body>
</html>