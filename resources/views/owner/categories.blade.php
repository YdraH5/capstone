@section('title', 'Category Management')

@section('content')
<x-owner-layout>
<div class="flex justify-end px-10 h-5"> 

<!-- Modal toggle -->
{{-- <x-slot name="header">
    <div class="flex justify-between items-center px-2">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('CATEGORIES') }}
        </h2>
        <button class="" x-data x-on:click="$dispatch('open-modal',{name:'add-category'})">
            @include('buttons.add')
        </button>
    </div>
</x-slot> --}}
@livewire('category-form') 

    <div class="py-4">
        <div class="min-w-full mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="flex flex-col">
                    @livewire('category-table')   
                </div>
            </div>
        </div>
    </div>


    @stop           
</x-owner-layout>
