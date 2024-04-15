@section('title', 'Reservation Mangement')

@section('content')
<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('RESERVATIONS') }}
        </h2>
    </div>
  </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="flex flex-col">
                   @livewire('reserve-table')   
                </div>
            </div>
        </div>
    </div>
    
    @stop           
</x-app-layout>
