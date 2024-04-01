@section('title', 'Upload Images')
@section('navs')
<a href="{{ route('categories.index') }}" class = "inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
  {{ __('Manage Category') }}
</a>
@stop
@section('navs2')
<a href="{{ route('appartment.index') }}" class = "inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
  {{ $category->name }} Images
</a>
@stop
@section('content')
<x-app-layout>
 
    <button id="showFormButton">
      @include('buttons.add')
    </button>
    <form action="{{url('categories/'.$category->id.'/upload')}}"method="POST"enctype="multipart/form-data" id="uploadForm"class="hidden">
        @csrf
      <input type="file" name="images[]" id="fileInput" class="border p-2"multiple>
      <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Submit</button>
    </form>

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