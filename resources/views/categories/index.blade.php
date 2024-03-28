@section('title', 'Category Management')
@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Manage Category') }}
        </h2>
        @section('search'){{-- to add search button for categories --}}
        <form action="/search" class="max-w-[480px] w-full px-4">
            @csrf
            @include('buttons.search')
        </form>
        @endsection {{--to end the section for search box--}}
        <div id="hide-div"class="">
            <form action="{{route('categories.create')}}"method="post">
                @csrf
                @method('post')
                <div class="grid gap-0 sm,md:grid-cols-1 lg:grid-cols-3">
                <div>
                    <input type="text" name="name" placeholder="Name"class="lg:w-80 sm:w-40">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <input type="text" name="description" placeholder="Description"class="lg:w-80 sm:w-40">
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
                <div>
                    <input type="submit" value="Add to Category">
                </div>
                </div>
            </form>
        </div>
    </x-slot>
        @include('buttons.add')
        {{-- not final will make it modal later  --}}

   

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col ">
                    
                          @include('categories.table')     
                </div>
            </div>
        </div>
    </div>
    
    @stop           
</x-app-layout>
