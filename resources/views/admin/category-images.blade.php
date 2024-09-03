@section('title', 'Images Management')

<x-app-layout>
    @section('content')
        
    @livewire('apartment-form')
    <div class="py-4">
        <div class="min-w-full mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="flex flex-col">
                    @livewire('images-table')   
                </div>
            </div>
        </div>
    </div>
    
    @endsection
</x-app-layout>
