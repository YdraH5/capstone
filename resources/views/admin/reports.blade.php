@section('title', 'Report Mangement')

@section('content')
<x-app-layout>

    <div class="py-4">
        <div class="min-w-full mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="flex flex-col">
                   @livewire('report-table')   
                </div>
            </div>
        </div>
    </div>
    
    @stop           
</x-app-layout>
