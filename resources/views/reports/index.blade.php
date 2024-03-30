@section('title', 'Report Mangement')
@section('navs')
<a href="{{ route('reports.index') }}" class = "inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
  {{ __('Manage Report') }}
</a>
@stop
@section('content')
<x-app-layout>
        
        @include('buttons.add')
        {{-- not final will make it modal later  --}}
        <div id="hide-div"class="">
            <form action="{{route('reports.create')}}"method="post">
                @csrf
                @method('post')
                <div class="grid gap-0 sm,md:grid-cols-1 lg:grid-cols-3">
                    <input type="number" name="user_id"value="{{Auth::user()->id;}}"hidden> 
                    <input type="text" name="ticket"value="{{$ticket}}"hidden>     
    
                <div>
                  <select name="report_category" id="cars" class="h-10 block mt-1 w-full space-x-8 sm:-my-px sm:ms-10">
                    <option value="">Report Category</option>
                    <option value="maintenance">maintenance</option>
                    <option value="Room service">Room service</option>
                    <option value="loud">loud</option>
                  </select>
                    <x-input-error :messages="$errors->get('report_category')" class="mt-2" />
                </div>
                <div>
                  <input type="text" name="description" placeholder="Description"class="h-10 block mt-1 w-full space-x-8 sm:-my-px sm:ms-10">
                  <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
                <div class="space-x-8 sm:-my-px sm:ms-10">
                    <input type="submit" value="Add to Report">
                </div>
                </div>
            </form>
        </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>    
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col ">
                    
                          @include('reports.table')     
                </div>
            </div>
        </div>
    </div>
    
    @stop           
</x-app-layout>
