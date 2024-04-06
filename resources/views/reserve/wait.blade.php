@section('title', 'Waiting')
@include('layouts-waiting.app')
    <div class="min-h-screen flex flex-col justify-center items-center">
        <h1 class="text-3xl font-bold mb-6">Welcome to the Reservation Waiting Page</h1>
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <p class="text-lg mb-4">Please wait patiently for access to the renters module.</p>
            @foreach($reserveDate as $date)
            @section('id','{{$date->apartment_id}}')
            <p class="text-lg mb-4">Your reservation date is <span id="reservationDate" class="font-semibold">{{ date('l, F jS Y', strtotime($date->check_in)) }}</span>.</p>
            <input type="hidden" value="{{$date->check_in}}" id="reservedDate">
            @endforeach
            <div id="countdown" class="text-2xl font-bold"></div>
        </div>
    </div>

    <script>
        window.onload = function() {
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
                }
            }, 1000);
        }
    </script>
</body>
</html>
