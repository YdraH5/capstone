@section('title', 'Waiting')
<x-reserve-layout>
    @section('waiting')

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
<script src="">
    window.onload = function () {
        const reservedDateInput = document.getElementById('reservedDate');
        const reservedDate = new Date(reservedDateInput.value).getTime();

        if (isNaN(reservedDate)) {
            alert("Please select a valid date.");
            return;
        }

        document.getElementById('countdown').classList.remove('hidden');
        startCountdown(reservedDate);
    };

    function startCountdown(targetDate) {
        const countdownInterval = setInterval(() => {
            const now = new Date().getTime();
            const distance = targetDate - now;
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById('countdown').innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            if (distance < 0) {
                clearInterval(countdownInterval);
                document.getElementById('countdown').innerHTML = "Reservation Date Reached!";
                document.getElementById('doneButton').classList.remove('hidden');
            }
        }, 1000);
    }
</script>