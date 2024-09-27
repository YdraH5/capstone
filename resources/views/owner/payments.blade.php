@section('title', 'Manage Payment')

@section('content')
<x-owner-layout>

  @livewire('payment-form')

    <div class="py-4">
        <div class="min-w-full mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="flex flex-col">
                   @livewire('payment-table')   
                </div>
            </div>
        </div>
    </div>
    
    @stop           
</x-owner-layout>