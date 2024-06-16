@section('title', 'Users Mangement')

@section('content')
<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center px-2">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('USERS') }}
        </h2>
    </div>
  </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="flex flex-col">
                   @livewire('user-table')   
                </div>
            </div>
        </div>
    </div>
    
    @stop           
</x-app-layout>
