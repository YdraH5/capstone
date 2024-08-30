@section('title', 'Waiting')
<x-reserve-layout>
    @section('waiting')
    @if (session('success'))
    <div class="alert alert-success text-green-500">
        {{ session('success') }}
    </div>    
    @endif

    @foreach($reservations as $reservation)
    @if(Auth::user()->role ==='reserve')
    <div class="bg-yellow-100 min-h-screen flex flex-col justify-center items-center">
    <h1 class="text-3xl font-bold mb-6">Welcome to the Reservation Waiting Page</h1>
        <div class=" p-8 rounded-lg shadow-lg">
            <p class="text-lg mb-4">Please wait patiently for access to the renters module.</p>
            <p class="text-lg mb-4">Your reservation date is <span id="reservationDate" class="font-semibold">{{ date('l, F jS Y', strtotime($reservation->check_in)) }}</span>.</p>
            <input type="hidden" value="{{$reservation->check_in}}" id="reservedDate">
            <div id="countdown" class="text-2xl font-bold"></div>
            <a href="{{route('reserve.update',['id' => Auth::user()->id,
                                            'apartment' => $reservation->apartment_id,
                                            'reservation' => $reservation->reservation_id  ])}}">
            <button id="doneButton" class="hidden bg-blue-500 text-white px-4 py-2 rounded mt-4">Go to renters page</button>
            </a>
        </div>
    </div>
    @endif
    @if(Auth::user()->role ==='pending')
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