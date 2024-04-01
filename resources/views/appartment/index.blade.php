@section('title', 'Appartment Management')
@section('navs')
<a href="{{ route('appartment.index') }}" class = "inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
  {{ __('Apartment') }}
</a>
@stop
@section('content')
<x-app-layout>
    <button data-modal-target="#crud-modal-apartment" data-modal-toggle="crud-modal-apartment"type="button">
        @include('buttons.add')
    </button>  
{{-- <div id="hide-div"class="">
    <form action="{{route('appartment.create')}}"method="post">
        @csrf
        @method('post')
        <div class="grid gap-4 sm:grid-cols-1 lg:grid-cols-2">
        <div>
            <select name="category_id"placeholder="Category"class="lg:w-80 sm:w-40 md:w-20 lg:h-10 sm:h-10">
                <option value="" disabled selected hidden>Category</option>
        @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
            </select>
            <x-input-error :messages="$errors->get('category')" class="mt-2" />
        </div>
        <div>
            <input type="text" name="room_number" placeholder="Room #"class="lg:w-80 sm:w-40 lg:h-10 sm:h-10">
            <x-input-error :messages="$errors->get('room_number')" class="mt-2" />
        </div>
        <div>
            <input type="text" name="price" placeholder="Price"class="lg:w-80 sm:w-40 lg:h-10 sm:h-10">
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>
        <div>
            <select name="status"class="lg:w-80 sm:w-40 lg:h-10 sm:h-10">
                <option value="" disabled selected hidden>Status</option>
                <option value="Available">Available</option>
                <option value="Unavailable">Unavailable</option>
                <option value="Maintenance">Maintenance</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>
            
        <div class="text-center">
            <input type="submit" value="Add to Appartment">
        </div>
        </div>
    </form>
</div>  --}}
<div id="crud-modal-apartment" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 flex items-center justify-center z-50" style="padding-top: 100px;">
    <div class="flex justify-center items-center w-full h-full">
        <div class="relative p-4 w-full max-w-md">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Add new Apartment
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal-apartment">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{route('appartment.create')}}" method="post" class="p-4 md:p-5">
                    @csrf
                    @method('post')
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Room Category</label>
                        <select name="category_id"placeholder="Category"class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" disabled selected hidden>Category</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>
                            <div class="col-span-2">
                                <label for="room-number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Room Number</label>
                                <input type="number" name="room_number" placeholder="Room #" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <x-input-error :messages="$errors->get('room_number')" class="mt-2" />
                            </div>
                            <div class="col-span-2">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price/monthly</label>
                                <input type="number" name="price" placeholder="Price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <div class="col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Room Status</label>
                            <select name="status"class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"">
                                <option value="" disabled selected hidden>Status</option>
                                <option value="Available">Available</option>
                                <option value="Unavailable">Unavailable</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Add to Apartment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div> 








<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex flex-col ">
                      @include('appartment.table')     
            </div>
        </div>
    </div>
</div>
    
          
                      
                    
             
@stop
</x-app-layout>
