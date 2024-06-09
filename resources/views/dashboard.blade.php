<x-app-layout>
  @section('title','Dashboard')
    <a href="{{ route('dashboard') }}" class = "inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
      {{ __('Dashboard') }}
    </a>
  @section('content')
  <section class="text-gray-700 body-font mx-8">

    <div class="container px-5 py-1  ">
      <div class="flex flex-wrap -m-4 text-center">
        <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
          <a href="{{route('admin.users.index')}}">
          <div class="border-2 border-gray-600 px-4 py-6 rounded-lg transform transition duration-500 hover:scale-110">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
              <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"></path>
            </svg>
            <h2 class="title-font font-medium text-3xl text-gray-900">{{\App\Models\User::all()->count() }}</h2>
            <p class="leading-relaxed">Users</p>
          </div>
          </a>
        </div>
        <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
          <a href="{{route('admin.users.index')}}">
          <div class="border-2 border-gray-600 px-4 py-6 rounded-lg transform transition duration-500 hover:scale-110">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-red-500 w-12 h-12 mb-3 inline-block">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
            </svg>  
            <h2 class="title-font font-medium text-3xl text-gray-900">{{\App\Models\Report::all()->count() }}</h2>
            <p class="leading-relaxed">Reports</p>
          </div>
          </a>
        </div>
        <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
          <div class="border-2 border-gray-600 px-4 py-6 rounded-lg transform transition duration-500 hover:scale-110">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-green-500 w-12 h-12 mb-3 inline-block">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
            </svg>
            
                  <h2 class="title-font font-medium text-3xl text-gray-900">
                                    {{\Illuminate\Support\Facades\DB::table('apartment')
                                    ->whereNull('renter_id')
                                    ->count()}}</h2>
            <p class="leading-relaxed">Vacant Room</p>
          </div>
        </div>
        <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
          <div class="border-2 border-gray-600 px-4 py-6 rounded-lg transform transition duration-500 hover:scale-110">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-indigo-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            </svg>
            <h2 class="title-font font-medium text-3xl text-gray-900">
            {{\Illuminate\Support\Facades\DB::table('reservations')
            ->whereNotNull('user_id')
            ->whereDate('check_in', '>', \Carbon\Carbon::now())
            ->count()
            }}
          </h2>                
          <p class="leading-relaxed">Reservations</p>
          </div>
        </div>
      </div>
    </div>
  

  </section>
  @stop
</x-app-layout>