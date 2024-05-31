<div class="fixed w-full z-30 flex bg-[#0F172A] p-2 items-center justify-center h-14 px-10">
  {{-- border-b border-gray-100 --}}
  {{-- i will change the color of navigation --}}
    <div class="logo ml-0 transform ease-in-out duration-500 flex-none h-full flex items-center justify-center">
      <div class="logo shrink-0 flex items-center">
        <a href="{{ route('welcome') }}">
          <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
        </a>
      </div>
    </div>
    
    <!-- SPACER -->
    <div class="grow h-full flex items-center justify-center"></div>
     <!-- Settings Dropdown -->
     <div class="hidden md:flex sm:items-center sm:ms-6">                    
      <x-dropdown align="right" width="48">
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
    <div class="-me-2 flex items-center md:hidden">
      <nav x-data="{ open: false }">
        
        <button class="w-14 h-14 relative focus:outline-none rounded" @click="open = !open">
          <div class="block w-5 absolute left-6 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <svg class="h-6 w-6" stroke="gray" fill="none" viewBox="0 0 24 24">
              <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </div>
        </button>
        <div class="absolute top-16 left-0 w-full bg-gray-800 z-10" x-show="open" @click.away="open = false">
            <ul class="py-4 overflow-y-auto max-h-80">
                <x-responsive-nav-link href="{{ route('dashboard') }}" 
                   active="{{ request()->routeIs('dashboard') }}" 
                   class="flex items-center px-4 py-2 text-white hover:bg-gray-700">
                  @include('components.dashboard-icon')
                  Dashboard
                </x-responsive-nav-link>
    
                <x-responsive-nav-link  :href="route('admin.users.index')" 
                    :active="request()->routeIs('admin.users.index')"
                    class="flex items-center px-4 py-2 text-white hover:bg-gray-700">
                    @include('components.users-icon')
                    Users
                </x-responsive-nav-link>

                <x-responsive-nav-link  href="{{ route('admin.apartment.index') }}" 
                    :active="request()->routeIs('admin.apartment.index')" 
                    class="flex items-center px-4 py-2 text-white hover:bg-gray-700">
                    @include('components.apartment-icon') 
                    Aparment
                </x-responsive-nav-link>

                <x-responsive-nav-link  href="{{ route('admin.categories.index') }}" 
                    :active="request()->routeIs('admin.categories.index')" 
                    class="flex items-center px-4 py-2 text-white hover:bg-gray-700">
                    @include('components.category-icon') 
                    Categories
                </x-responsive-nav-link>

                <x-responsive-nav-link  href="{{ route('admin.reports.index') }}" 
                    :active="request()->routeIs('admin.reports.index')" 
                    class="flex items-center px-4 py-2 text-white hover:bg-gray-700">
                    @include('components.report-icon') 
                    Reports
                </x-responsive-nav-link>
                
                <x-responsive-nav-link  href="{{ route('admin.reserve.index') }}" 
                    :active="request()->routeIs('admin.reserve.index')" 
                    class="flex items-center px-4 py-2 text-white hover:bg-gray-700">
                    @include('components.calendar-icon') 
                    Reserves
                </x-responsive-nav-link>
                <x-responsive-nav-link  href="{{ route('admin.payments.index') }}" 
                    :active="request()->routeIs('admin.payments.index')" 
                    class="flex items-center px-4 py-2 text-white hover:bg-gray-700">
                    @include('components.payment-icon') 
                    Payments
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf

                  <x-responsive-nav-link :href="route('logout')"
                          onclick="event.preventDefault();
                                      this.closest('form').submit();">
                      {{ __('Log Out') }}
                  </x-responsive-nav-link>
              </form>
            </ul>
        </div>
      </nav>
    </div>
  </div>
  <aside class="hidden md:block w-60 -translate-x-48 fixed z-50 flex h-screen bg-[#0F172A]">
    <!-- MINI SIDEBAR-->
    <div class="mini mt-20 flex flex-col space-y-2 w-full h-[calc(100vh)]">
      <div class="group hover:ml-16 relative justify-end pr-5 text-white hover:text-blue-500 w-full bg-[#0F172A] p-3 rounded-full transform ease-in-out duration-300 flex">
        <x-nav-link href="{{ route('dashboard') }}" active="{{ request()->routeIs('dashboard') }}">
          <span class="opacity-0 group-hover:opacity-100 transition-opacity">Dashboard</span>
          @include('components.dashboard-icon')
        </x-nav-link>
      </div>

      <div class="group hover:ml-16 relative justify-end pr-5 text-white hover:text-blue-500 w-full bg-[#0F172A] p-3 rounded-full transform ease-in-out duration-300 flex">
          <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
              <span class="opacity-0 group-hover:opacity-100 transition-opacity">Users</span>
              @include('components.users-icon')
          </x-nav-link>
      </div>

      <div class="group hover:ml-16 relative justify-end pr-5 text-white hover:text-blue-500 w-full bg-[#0F172A] p-3 rounded-full transform ease-in-out duration-300 flex">
        <x-nav-link href="{{ route('admin.apartment.index') }}" :active="request()->routeIs('admin.apartment.*')">
            <span class="opacity-0 group-hover:opacity-100 transition-opacity">Aparment</span>
              @include('components.apartment-icon')   
          </x-nav-link>
      </div>
      <div class="group hover:ml-16 relative justify-end pr-5 text-white hover:text-blue-500 w-full bg-[#0F172A] p-3 rounded-full transform ease-in-out duration-300 flex">
          <x-nav-link href="{{ route('admin.categories.index') }}" active="{{ request()->routeIs('admin.categories.*') }}">
              <span class="opacity-0 group-hover:opacity-100 transition-opacity">Category</span>
              @include('components.category-icon')   
          </x-nav-link>
      </div>

      <div class="group hover:ml-16 relative justify-end pr-5 text-white hover:text-blue-500 w-full bg-[#0F172A] p-3 rounded-full transform ease-in-out duration-300 flex">
          <x-nav-link href="{{ route('admin.reports.index') }}" active="{{ request()->routeIs('admin.reports.*') }}">
              <span class="opacity-0 group-hover:opacity-100 transition-opacity">Report</span>
              @include('components.report-icon')  
          </x-nav-link>
      </div>
      <div class="group hover:ml-16 relative justify-end pr-5 text-white hover:text-blue-500 w-full bg-[#0F172A] p-3 rounded-full transform ease-in-out duration-300 flex">
        <x-nav-link href="{{ route('admin.reserve.index') }}" active="{{ request()->routeIs('admin.reserve.*') }}">
            <span class="opacity-0 group-hover:opacity-100 transition-opacity">Reserve</span>
            @include('components.calendar-icon')  
        </x-nav-link>
      </div>
      <div class="group hover:ml-16 relative justify-end pr-5 text-white hover:text-blue-500 w-full bg-[#0F172A] p-3 rounded-full transform ease-in-out duration-300 flex">
        <x-nav-link href="{{ route('admin.payments.index') }}" active="{{ request()->routeIs('admin.payments.*') }}">
            <span class="opacity-0 group-hover:opacity-100 transition-opacity">Payments</span>
            @include('components.payment-icon')  
        </x-nav-link>
      </div>
  </div>
</aside>
<!-- CONTENT -->
<div class="container mx-auto">
  <div class="content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4 ">
    <div class="flex flex-wrap my-2 -mx-2">
    </div>

</div>