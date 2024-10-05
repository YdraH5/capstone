@section('title', 'Waiting')
<x-reserve-layout>
    @section('waiting')
    @if (session('success'))
    <div class="alert alert-success text-green-500">
        {{ session('success') }}
    </div>    
    @endif

    @foreach($reservations as $reservation)
    @if(Auth::user()->role === 'reserve')
    <div class="bg-yellow-100 min-h-screen flex flex-col justify-center items-center">
        <h1 class="text-3xl font-bold mb-6">Welcome to the Reservation Waiting Page</h1>
        <div class="p-8 rounded-lg shadow-lg">
            <p class="text-lg mb-4">Please wait patiently for access to the renters module.</p>
            <p class="text-lg mb-4">Your reservation date is <span id="reservationDate" class="font-semibold">{{ date('l, F jS Y', strtotime($reservation->check_in)) }}</span>.</p>
            <input type="hidden" value="{{ $reservation->created_at }}" id="createdDate">
            <input type="hidden" value="{{ $reservation->check_in }}" id="checkInDate">
            <div id="countdown" class="text-2xl font-bold"></div>

            <!-- Go to renters page button (hidden until check-in date has passed) -->
            <a href="{{ route('reserve.update', ['id' => Auth::user()->id, 'apartment' => $reservation->apartment_id, 'reservation' => $reservation->reservation_id]) }}">
                <button id="doneButton" class="hidden bg-blue-500 text-white px-4 py-2 rounded mt-4">Go to renters page</button>
            </a>

            <!-- Note about cancellation policy -->
            <p class="text-red-500 text-sm mt-4">*Note: Reservation can only be canceled or refunded within 3 days of the reservation was submitted date.</p>

            <!-- Cancel reservation button (hidden if more than 3 days have passed since creation) -->
                <!-- Cancel reservation button (hidden if more than 3 days have passed since creation) -->
                <button id="cancelButton" class="bg-red-500 text-white px-4 py-2 rounded"
                    x-data x-on:click="$dispatch('open-modal',{name:'reserve-cancel'})">
                    Cancel Reservation
                </button>

                <x-modal name="reserve-cancel" title="Are you sure you want to cancel this reservation?">
                    <x-slot name="body">
                        <p class="mb-4">
                            Please note that once you cancel this reservation, the room you reserved will become available for others to book. 
                            This action is irreversible, and you will need to make a new reservation if you wish to book the room again. This action will redirect you to the home page.
                        </p>
                        <div class="flex justify-end space-x-2">
                            <!-- Close Button -->
                            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="Livewire.emit('closeModal')">
                                Keep Reservation
                            </button>
                            <!-- Cancel Reservation Button -->
                            <a href="{{ route('reserve.cancel', $reservation->reservation_id) }}">
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Cancel Reservation</button>
                            </a>
                        </div>
                    </x-slot>
                </x-modal>

        </div>
    </div>
    @endif

    @if(Auth::user()->role === 'pending')
    <div class="min-h-screen flex flex-col justify-center items-center">    
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-6">Your payment is under review.</h1>
            <p class="text-lg mb-4">Please wait patiently for access to the renters module.</p>
        </div>
    </div>
    @endif
    @endforeach
@stop

</x-reserve-layout>

<script>
    window.onload = function () {
    const createdDateInput = document.getElementById('createdDate');
    const createdDate = new Date(createdDateInput.value).getTime();
    const checkInDateInput = document.getElementById('checkInDate');
    const checkInDate = new Date(checkInDateInput.value).getTime();

    const now = new Date().getTime();
    const threeDaysInMillis = 3 * 24 * 60 * 60 * 1000;

    // Show "Go to renters page" button if the current time is past the check-in date
    if (now >= checkInDate) {
        document.getElementById('doneButton').classList.remove('hidden');
    }

    // Hide "Cancel Reservation" button if more than 3 days have passed since creation
    if (now - createdDate > threeDaysInMillis) {
        document.getElementById('cancelButton').style.display = 'none';
    }
};

</script>
