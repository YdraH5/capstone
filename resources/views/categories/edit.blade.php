@section('title', 'Edit Category')
@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>
    <form action="{{route('categories.update',['categories' => $categories])}}"method="post">
        @csrf
        @method('put')
        <div>
            <label for="name">Category Name</label>
            <input type="text" name="name" placeholder="Name"value="{{$categories->name}}">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div>
            <label for="description">Description</label>
            <input type="text" name="description" placeholder="Description"value="{{$categories->description}}">
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>
        <div>
            <input type="submit" value="Update">
        </div>
    </form>
    @stop           
</x-app-layout>