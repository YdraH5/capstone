
  
<nav x-data="{ open: false }" class="bg-gray-900 text-white sticky top-0 z-50">
  <!-- Primary Navigation Menu -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
          <div class="flex">
              <!-- Logo -->
              <div class="logo shrink-0 flex items-center">
                  <a href="{{ route('welcome') }}">
                    <img src="{{ asset('images/NRN LOGO.png') }}" style="height: 40px; width:70px"class="sm:mx-4 lg:mx-6 lg:h-40 lg:w-60">
                  </a>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link href="{{ route('welcome') }}#overview" :active="request()->fullUrlIs(route('welcome') . '#overview')">
                  {{ __('Overview') }}
                </x-nav-link>
                
                <x-nav-link href="{{ route('welcome') }}#establishment" :active="request()->fullUrlIs(route('welcome') . '#establishment')">
                  {{ __('Establishments') }}
                </x-nav-link>

                <x-nav-link href="{{ route('welcome') }}#reserve" :active="request()->fullUrlIs(route('welcome') . '#reserve')">
                  {{ __('Reserve') }}
                </x-nav-link>
                {{-- <x-nav-link  :href="route('mail')" :active="request()->routeIs('mail')">
                  {{ __('Email') }}
                </x-nav-link> --}}
              </div>
              {{--container for login and register  --}}
              @if(Auth::check())
              <div class="inline-flex absolute top-4 right-2 space-x-reverse space-y-0 hidden sm:flex sm:items-center sm:ms-6">                    
                <x-dropdown >
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black-500 bg-gray-300 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">                                
                            @include('components.user-icon')
                            <div class="flex ">                
                                {{ Auth::user()->name }}
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @else
 
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
              @endif
             

          </div>
          <div class="-me-2 flex items-center sm:hidden">
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
      @if(Auth::check())
        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
          @csrf

          <x-responsive-nav-link :href="route('logout')"
                  onclick="event.preventDefault();
                              this.closest('form').submit();">
              {{ __('Log Out') }}
          </x-responsive-nav-link>
      </form>
      @endif
        <x-responsive-nav-link   :href="route('welcome')" :active="request()->routeIs('welcome')">
        {{ __('Available') }}
        </x-responsive-nav-link>
        @if(!Auth::check())
        <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('auth.login')">
            {{ __('Login') }}
        </x-responsive-nav-link>

        <x-responsive-nav-link  :href="route('register')" :active="request()->routeIs('auth.register')">
          {{ __('Register') }}
        </x-responsive-nav-link>
        @else
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <a href="route('logout')" class="block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 text-start text-base font-medium text-indigo-700  focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out'
          : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">

          </a>
          
        </form>
        @endif
    </div>
  </div>
</nav>