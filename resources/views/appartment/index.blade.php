@section('title', 'Appartment Management')
@section('navs')
<a href="{{ route('appartment.index') }}" class = "inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
  {{ __('Apartment') }}
</a>
@stop
@section('content')
<x-app-layout>
  
    @include('buttons.add')

<div id="hide-div"class="">
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
            <x-input-error :messages="$errors->get('building')" class="mt-2" />
        </div>
            
        <div class="text-center">
            <input type="submit" value="Add to Appartment">
        </div>
        </div>
    </form>
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
