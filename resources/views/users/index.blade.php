@section('title', 'Users Management')
@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex h-8">
        <h2 class="font-semibold text-xl">
            {{ __('Manage User') }}
        </h2>
        @section('search'){{-- to add search button for users --}}
        <form action="/search" class="max-w-[480px] w-full px-4">
            @csrf
            @include('buttons.search')
        </form>
        @endsection {{--to end the section for search box--}}
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col ">
                    <div class="overflow-x-auto">
                        @include('users.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
     @stop           
</x-app-layout>
