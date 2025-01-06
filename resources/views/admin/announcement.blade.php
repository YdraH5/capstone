@section('title', 'Announcement Management')

<x-app-layout>
    @section('content')
        
    @livewire('announcement-form')
    <div class="py-4">
        <div class="min-w-full mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="flex flex-col">
                    @livewire('announcement-table') 
                </div>
            </div>
        </div>
    </div>
    
    @endsection
</x-app-layout>
