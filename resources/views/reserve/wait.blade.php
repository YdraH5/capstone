@section('title', 'Waiting')
<x-reserve-layout>
    @section('waiting')
    @if (session('success'))
    <div class="alert alert-success text-green-500">
        {{ session('success') }}
    </div>    
    @endif
<div class="min-h-screen flex flex-col justify-center items-center">
    <h1 class="text-3xl font-bold mb-6">Welcome to the Reservation Waiting Page</h1>
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <p class="text-lg mb-4">Please wait patiently for access to the renters module.</p>
        @foreach($reservations as $reservation)
        <p class="text-lg mb-4">Your reservation date is <span id="reservationDate" class="font-semibold">{{ date('l, F jS Y', strtotime($reservation->check_in)) }}</span>.</p>
        <input type="hidden" value="{{$reservation->check_in}}" id="reservedDate">
        <div id="countdown" class="text-2xl font-bold"></div>
        <a href="{{route('reserve.update',['id' => Auth::user()->id,
                                         'apartment' => $reservation->apartment_id,
                                         'reservation' => $reservation->id  ])}}">
        <button id="doneButton" class="hidden bg-blue-500 text-white px-4 py-2 rounded mt-4">Go to renters page</button>
        </a>
    </div>
    @endforeach
</div>
@stop

</x-reserve-layout>
<script>
    window.onload = function () {
        const reservedDateInput = document.getElementById('reservedDate');
        const reservedDate = new Date(reservedDateInput.value).getTime();

        if (isNaN(reservedDate)) {
            alert("Please select a valid date.");
            return;
        }

        const now = new Date().getTime();
        if (now >= reservedDate) {
            document.getElementById('doneButton').classList.remove('hidden');
        }
    };
</script>