@section('title', 'Apartment Management')

<x-owner-layout>
    @section('content')
        
    @livewire('apartment-form')
    <div class="py-4">
        <div class="min-w-full mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="flex flex-col">
                    @livewire('apartment-table')   
                </div>
            </div>
        </div>
    </div>
    
    @endsection
</x-owner-layout>
