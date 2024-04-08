@section('title', 'Category Management')

@section('content')
<x-app-layout>
<div class="flex justify-end px-10 h-5"> 

<!-- Modal toggle -->
<x-slot name="header">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
        {{ __('CATEGORIES') }}
    </h2>
    <div class="flex justify-end px-10 h-5"> 
        <button id="openModalButton"class="">
            @include('buttons.add')
        </button> 
</x-slot>
  <!-- Main modal -->
    <div id="modal" class="hidden fixed inset-0 z-50 overflow-auto bg-gray-500 bg-opacity-75 flex justify-center items-center h-screen">
        <div class="bg-white p-4 rounded-lg shadow-lg sm:w-96 w-full">
            <h1 class="text-2xl font-bold mb-4 text-center">Apartment Category</h1>
                <!-- Form -->
            <form id="modalForm" class="space-y-4"action="{{route('categories.create')}}"method="post">
                @csrf
                @method('post')
                    <div>
                        <label for="email" class="block font-medium opacity-70">Category Name</label>
                        <input type="text" name="name" class="w-full rounded-lg " placeholder="Category Name">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <label for="email" class="block font-medium opacity-70">Description</label>
                        <textarea id="description" rows="4" class="w-full rounded-lg " name="description" placeholder="Write product description here">
                        </textarea>   
                    </div>
                    <div class="flex justify-end">
                    <div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                    </div>
                    <button id="closeModalButton" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded ml-2">Close</button>
                    </div>
            </form>
        </div>
    </div>
</div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col ">
                    
                          @include('admin.categories.table')     
                </div>
            </div>
        </div>
    </div>


    @stop           
</x-app-layout>
