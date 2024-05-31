@section('title', 'Manage Payment')

@section('content')
<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Payments') }}
        </h2>
        <button class="" x-data x-on:click="$dispatch('open-modal',{name:'add-payment'})">
            @include('buttons.add')
        </button> 
    </div>
  </x-slot>

  @livewire('payment-form')

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="flex flex-col">
                   @livewire('payment-table')   
                </div>
            </div>
        </div>
    </div>
    
    @stop           
</x-app-layout>