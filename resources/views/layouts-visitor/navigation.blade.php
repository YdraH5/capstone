
  
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
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex ">
                  <x-nav-link  :href="route('login')" :active="request()->routeIs('login')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>                    
                    {{ __('Log in') }}
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
