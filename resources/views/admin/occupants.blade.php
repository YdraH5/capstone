@section('title', 'Occupants Management')

<x-app-layout>
    @section('content')
        
    <div class="py-4">
        <div class="min-w-full mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="flex flex-col">
                    @livewire('occupants-table')   
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
