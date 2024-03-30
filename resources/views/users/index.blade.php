@section('title', 'Users Management')
@section('navs')
<a href="{{ route('users.index') }}" class = "inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
  {{ __('Manage User') }}
</a>
@stop
@section('content')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col ">
                    <div class="overflow-x-auto">
                        @include('users.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
     @stop           
</x-app-layout>
