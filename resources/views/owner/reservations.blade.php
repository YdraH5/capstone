@section('title', 'Reservation Mangement')

@section('content')
<x-owner-layout>

    <div class="py-4">
        <div class="min-w-full mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="flex flex-col">
                   @livewire('reserve-table')   
                </div>
            </div>
        </div>
    </div>
    
    @stop           
</x-owner-layout>
