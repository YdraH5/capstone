<div>
    <div class = "fixed w-full z-30 flex bg-white dark:bg-[#0F172A] p-2 items-center justify-center h-20 px-10">
        <div class = "logo ml-12 dark:text-white  transform ease-in-out duration-500 flex-none h-full flex items-center justify-center">
            <div class="shrink-0 flex items-center">
              <a href="{{ route('dashboard') }}"wire:navigate>
                  NRN Building
              </a>
          </div>
        </div>
        <!-- SPACER -->
        <div class = "grow h-full flex items-center justify-center"></div>
            <div class = "flex-none h-full text-center flex items-center justify-center">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <div class = "flex space-x-3 items-center px-3">
                        <div class = "flex-none flex justify-center">
                        <div class="w-8 h-8 flex  dark:text-white hover:text-blue-500 dark:hover:text-[#38BDF8] cursor-pointer">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShta_GXR2xdnsxSzj_GTcJHcNykjVKrCBrZ9qouUl0usuJWG2Rpr_PbTDu3sA9auNUH64&usqp=CAU" alt="profile" class="shadow rounded-full object-cover" />
                        </div>
                        </div>
    
                        <div class = "hidden md:block text-sm md:text-md text-black dark:text-white hover:text-blue-500 dark:hover:text-[#38BDF8] cursor-pointer">
                        {{ Auth::user()->name }}
                        </div>
                    </div> 
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
        </div>
    <aside class="w-60 -translate-x-48 fixed z-50 flex h-screen dark:bg-[#0F172A]">
        <!-- MINI SIDEBAR-->
        <div class="mini mt-20 flex flex-col space-y-2 w-full h-[calc(100vh)]">
            <div class="group hover:ml-16 relative justify-end pr-5 text-white dark:hover:text-blue-500 w-full dark:bg-[#0F172A] p-3 rounded-full transform ease-in-out duration-300 flex">
                <x-nav-link href="{{ route('dashboard') }}" active="{{ request()->routeIs('dashboard') }}">
                    <span class="opacity-0 group-hover:opacity-100 transition-opacity">Dashboard</span>
                    @include('components.dashboard-icon')
                    
                </x-nav-link>
            </div>
    
            <div class="group hover:ml-16 relative justify-end pr-5 text-white dark:hover:text-blue-500 w-full dark:bg-[#0F172A] p-3 rounded-full transform ease-in-out duration-300 flex">
                <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                    <span class="opacity-0 group-hover:opacity-100 transition-opacity">Users</span>
                    @include('components.users-icon')
                </x-nav-link>
            </div>

            <div class="group hover:ml-16 relative justify-end pr-5 text-white dark:hover:text-blue-500 w-full dark:bg-[#0F172A] p-3 rounded-full transform ease-in-out duration-300 flex">
                <x-nav-link href="{{ route('admin.apartment.index') }}" active="{{ request()->routeIs('admin.apartment.index') }}">
                    <span class="opacity-0 group-hover:opacity-100 transition-opacity">Aparment</span>
                    @include('components.apartment-icon')   
                </x-nav-link>
            </div>
            <div class="group hover:ml-16 relative justify-end pr-5 text-white dark:hover:text-blue-500 w-full dark:bg-[#0F172A] p-3 rounded-full transform ease-in-out duration-300 flex">
                <x-nav-link href="{{ route('admin.categories.index') }}" active="{{ request()->routeIs('admin.categories.index') }}">
                    <span class="opacity-0 group-hover:opacity-100 transition-opacity">Category</span>
                    @include('components.category-icon')   
                </x-nav-link>
            </div>

            <div class="group hover:ml-16 relative justify-end pr-5 text-white dark:hover:text-blue-500 w-full dark:bg-[#0F172A] p-3 rounded-full transform ease-in-out duration-300 flex">
                <x-nav-link href="{{ route('admin.reports.index') }}" active="{{ request()->routeIs('admin.reports.index') }}">
                    <span class="opacity-0 group-hover:opacity-100 transition-opacity">Report</span>
                    @include('components.report-icon')  
                </x-nav-link>
            </div>
        </div>
    </aside>
    <!-- CONTENT -->
    
    <div class = "content ml-12 transform ease-in-out duration-500 pt-20 px-2 md:px-5 pb-4 ">
      <div class = "flex flex-wrap my-2 -mx-2">
      

</div>
