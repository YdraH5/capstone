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
        {{ __('CATEGORIES') }}
    </h2>
    <div class="flex justify-end px-10 h-5"> 
        <button id="openModalButton"class="">
            @include('buttons.add')
        </button> 
</x-slot>
{{--  
    <button id="showFormButton">
      @include('buttons.add')
    </button>
    <form action="{{url('categories/'.$category->id.'/upload')}}"method="POST"enctype="multipart/form-data" id="uploadForm"class="hidden">
        @csrf
      <input type="file" name="images[]" id="fileInput" class="border p-2"multiple>
      <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Submit</button>
    </form> --}}
    <div id="modal" class="hidden fixed inset-0 z-50 overflow-auto bg-gray-500 bg-opacity-75 flex justify-center items-center h-screen">
      <div class="bg-white p-4 rounded-lg shadow-lg sm:w-96 w-full">
          <h1 class="text-2xl font-bold mb-4 text-center">Apartment Category</h1>
              <!-- Form -->
          <form id="modalForm" class="space-y-4"action="{{url('categories/'.$category->id.'/upload')}}"method="post"enctype="multipart/form-data" id="uploadForm"class="hidden">
              @csrf
                  <div>
                      <label  class="block font-medium opacity-70">Insert Images</label>
                      <input type="file" name="images[]" class="w-full rounded-lg " placeholder="Images"multiple>
                      <x-input-error :messages="$errors->get('images[]')" class="mt-2" />
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
                @if (session('success'))
                    <div>
                      {{session('success')}}
                    </div>
                @else
                @endif
              @include('category-images.table')

            </div>
          </div>
      </div>
  </div>
  @stop
</x-app-layout>