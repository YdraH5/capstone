@section('title', 'Appartment Management')

<x-app-layout>
    @section('content')

    <x-slot name="header">
        <div class="flex justify-between items-center px-10">
            <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
                {{ __('Manage Apartment') }}
            </h2>
                <button id="openModalButton"onclick="modalHandler(true)">
                    @include('buttons.add')
                </button> 
        </div>
    </x-slot>
  @livewire('apartment-form')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="flex flex-col ">
                    @livewire('apartment-table')   
                </div>
            </div>
        </div>
    </div>
      
@stop
</x-app-layout>
