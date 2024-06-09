@section('title', 'Upload Images')
@section('navs')
<a href="{{ route('admin.categories.index') }}" class = "inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
  {{ __('Manage Category') }}
</a>
@stop
@section('navs2')
<a href="{{ route('admin.apartment.index') }}" class = "inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
  {{ $category->name }} Images
</a>
@stop
@section('content')
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
        {{ __('IMAGES') }}
    </h2>
    <div class="flex justify-end px-10 h-5"> 
      <button class="" x-data x-on:click="$dispatch('open-modal',{name:'add-image'})">
        @include('buttons.add')
      </button>
</x-slot>
<x-modal name="add-image" title="Add Image">
  <x-slot:body>
          <form class="space-y-4"action="{{url('/admin/categories/'.$category->id.'/upload')}}"method="post"enctype="multipart/form-data" class="hidden">
              @csrf
                  <div>
                      <label  class="block font-medium opacity-70">Insert Images</label>
                      <input type="file" name="images[]" class="w-full rounded-lg " placeholder="Images"multiple>
                      <x-input-error :messages="$errors->get('images[]')" class="mt-2" />
                  </div>
                 
                    <div class="flex items-center justify-between py-8">
                      <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                      <button  x-on:click="$dispatch('close-modal',{name:'add-apartment'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close
                      </button>
                  </div>
          </form>
  </x-slot:body>
</x-modal>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex flex-col ">
                @if (session('success'))
                    <div class="text-green-400">
                      {{session('success')}}
                    </div>
                @else
                @endif
              @include('admin.category-images.table')

            </div>
          </div>
      </div>
  </div>
  @stop
</x-app-layout>