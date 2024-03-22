@section('title', 'Appartment Management')
@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="header">
        <h2 class="font-semibold text-xl text-green-800 dark:text-black-200 leading-tight">
            {{ __('Manage Appartment') }}
        </h2>
        @include('buttons.add')
        </div>
    </x-slot>

<div id="hide-div"class="">
    <form action="{{route('categories.index')}}"method="post">
        @csrf
        @method('post')
        <div class="grid gap-4 sm:grid-cols-1 lg:grid-cols-2">
        <div>
            <select name="building"class="lg:w-80 sm:w-40 lg:h-10 sm:h-10">
                <option value="" disabled selected hidden>Building</option>
                <option value="1">One</option>
                <option value="2">Two</option>
            </select>
            <x-input-error :messages="$errors->get('building')" class="mt-2" />
        </div>
        <div>
            <select name="category"placeholder="Category"class="lg:w-80 sm:w-40 md:w-20 lg:h-10 sm:h-10">
                <option value="" disabled selected hidden>Category</option>
        @foreach ($categories as $category)
                <option value="{{$category->name}}">{{$category->name}}</option>
        @endforeach
            </select>
            <x-input-error :messages="$errors->get('category')" class="mt-2" />
        </div>
        <div>
            <input type="text" name="price" placeholder="Price"class="lg:w-80 sm:w-40 lg:h-10 sm:h-10">
            <x-input-error :messages="$errors->get('number')" class="mt-2" />
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
            <input type="submit" value="Add to Category">
        </div>
        </div>
    </form>
</div> 

        <div class="h-screen">
            <div class="container mx-auto center">
                {{-- xs:grid-cols-1 sm:grid-cols-2 lg: --}}
                <div class="grid gap-2 grid-cols-4">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                    <img src="{{asset('images/lock.png')}}"style="width:300px;height:300px;"> 
                            </div>
                        <div class="flip-card-back">
                            <h1>John Doe</h1>
                            <p>Architect & Engineer</p>
                            <p>We love that guy</p>
                        </div>
                    </div>
                </div> 
                    
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                <img src="{{asset('images/lock.png')}}"style="width:300px;height:300px;"> 
                        </div>
                    <div class="flip-card-back">
                        <button>click</button>
                    </div>
                </div>
            </div> 

                </div>
                
            </div> 
        </div>    
          
                      
                    
             
@stop
</x-app-layout>
