@section('title', 'Edit Apartment')
@section('navs')
<a href="{{ route('appartment.index') }}" class = "inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
  {{ __('Manage Apartment') }}
</a>
@stop

@section('content')
<x-app-layout>
  <form action="{{route('appartment.update',['apartment' => $apartment])}}"method="post">
    @csrf
    @method('put')
    <div class="grid gap-4 sm:grid-cols-1 lg:grid-cols-2">
    <div>
      <label for="">Category</label><br>  
        <select name="category_id"placeholder="Category"class="lg:w-80 sm:w-40 md:w-20 lg:h-10 sm:h-10">
    @foreach ($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
    @endforeach
        </select>
        <x-input-error :messages="$errors->get('category')" class="mt-2" />
    </div>
    <div>
      <label for="">Room Number</label><br>
        <input type="text" name="room_number" value="{{$apartment->room_number}}" placeholder="Room #"class="lg:w-80 sm:w-40 lg:h-10 sm:h-10">
        <x-input-error :messages="$errors->get('room_number')" class="mt-2" />
    </div>
    <div>
      <label for="">Price/Month</label><br>
        <input type="text" name="price" value="{{$apartment->price}}" placeholder="Price"class="lg:w-80 sm:w-40 lg:h-10 sm:h-10">
        <x-input-error :messages="$errors->get('price')" class="mt-2" />
    </div>
    <div>
        <label for="">Status</label><br>
        <select name="status"class="lg:w-80 sm:w-40 lg:h-10 sm:h-10">
            <option value="" disabled selected hidden>{{$apartment->status}}</option>
            <option value="Available">Available</option>
            <option value="Unavailable">Unavailable</option>
            <option value="Maintenance">Maintenance</option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>
        
    <div class="text-center">
        <input type="submit" value="Update">
    </div>
    </div>
</form>
    @stop           
  </x-app-layout>

