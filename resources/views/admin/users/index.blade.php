@section('title', 'Users Management')

<x-app-layout>
    @section('content')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Manage Apartment') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col ">
                    <div class="overflow-x-auto">
                        @include('admin.users.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
     @stop           
</x-app-layout>
