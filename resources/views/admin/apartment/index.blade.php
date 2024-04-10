@section('title', 'Appartment Management')

<x-app-layout>
    @section('content')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Manage Apartment') }}
        </h2>
        <div class="flex justify-end px-10 h-5"> 
            <button id="openModalButton"class="">
                @include('buttons.add')
            </button> 
        </div>
    </x-slot>
  <!-- Main modal -->
    <div id="modal" class="hidden fixed inset-0 z-50 overflow-auto bg-gray-500 bg-opacity-75 flex justify-center items-center h-screen">
        <div class="bg-white p-4 rounded-lg shadow-lg sm:w-96 w-full">
            <h1 class="text-2xl font-bold mb-4 text-center">Apartment</h1>
                <!-- Form -->
            <form id="modalForm" class="space-y-4"action="{{route('appartment.create')}}"method="post">
                @csrf
                @method('post')
                    <div>
                        <label class="block font-medium opacity-70">Category Name</label>
                        <select name="category_id"placeholder="Category"class="w-full h-10 rounded-lg opacity-80">
                            <option value="" disabled selected hidden>Category</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium opacity-70">Status</label>
                        <select name="building"class="w-full h-10 rounded-lg">
                            <option value="" disabled selected hidden>Building</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                        </select>
                        <x-input-error :messages="$errors->get('building')" class="mt-2" />
                    </div>
                    <div>
                        <label class="block font-medium opacity-70">Room Number</label>
                        <input type="number" name="room_number" placeholder="Room #" class="w-full h-10 rounded-lg">
                        <x-input-error :messages="$errors->get('room_number')" class="mt-2" />  
                    </div>
                    <div>
                        <label class="block font-medium opacity-70">Price</label>
                        <input type="number" name="price" placeholder="Price" class="w-full h-10 rounded-lg">
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                    <div>
                        <label class="block font-medium opacity-70">Status</label>
                        <select name="status"class="w-full h-10 rounded-lg">
                            <option value="" disabled selected hidden>Status</option>
                            <option value="Available">Available</option>
                            <option value="Unavailable">Unavailable</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col ">
                    
                          @include('admin.apartment.table')     
                </div>
            </div>
        </div>
    </div>
      
@stop
</x-app-layout>
