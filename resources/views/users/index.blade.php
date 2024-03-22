@section('title', 'Users Management')
@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Manage User') }}
        </h2>
    </x-slot>
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
