@section('title', 'Edit Category')
@section('navs')
<a href="{{ route('admin.categories.index') }}" class = "inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
  {{ __('Manage Category') }}
</a>
@stop

@section('content')
<x-app-layout>
    <form action="{{route('categories.update',['categories' => $categories])}}"method="post"class="">
        @csrf
        @method('put')
        <div class="h-20">
            <label for="name">Category Name</label>
            <input type="text" name="name" placeholder="Name"value="{{$categories->name}}"class="w-full space-y-1">
            <x-input-error :messages="$errors->get('name')" class="mt-2 mb-5" />
        </div>
        <div class="h-20">
            <label for="description" class="mt-2">Description</label>
            <input type="text" name="description" placeholder="Description"value="{{$categories->description}}" class="w-full ">
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>
        <div>
            <input type="submit" value="Update">
        </div>
    </form>
    @stop           
</x-app-layout>

