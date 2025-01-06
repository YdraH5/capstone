@section('title', 'Waiting')
<x-reserve-layout>
    @section('waiting')
    @if (session('success'))
    <div class="alert alert-success text-green-500 text-center py-4 bg-green-100 rounded-md mb-4">
        {{ session('success') }}
    </div>    
    @endif

    @foreach($reservations as $reservation)
    @if(Auth::user()->role === 'reserve')
    <div class="bg-yellow-50 min-h-screen flex flex-col md:flex-row">
        <!-- Left Section: Image Carousel -->
        <div class="w-full md:w-1/2 p-4 h-64 md:h-screen flex items-center justify-center">
            <div id="imageCarousel" class="relative w-full h-full">
                <div class="carousel-inner h-full">
                    @foreach($images as $image)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }} h-full">
                        <img src="{{ asset($image->image) }}" alt="Apartment Overview" class="rounded-lg shadow-md w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
                <!-- Carousel controls -->
                <button class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full" id="prevButton">&#8249;</button>
                <button class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full" id="nextButton">&#8250;</button>
            </div>
        </div>

        <!-- Right Section: Reservation Details -->
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-4 md:p-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-4 md:mb-6 text-gray-800 text-center">Reservation Waiting Page</h1>
            <div class="p-4 md:p-8 bg-white rounded-lg shadow-lg w-full md:w-3/4">
                <p class="text-base md:text-lg mb-2 md:mb-4 text-gray-600 text-center">Please wait patiently for access to the renters module.</p>
                <p class="text-base md:text-lg mb-2 md:mb-4 text-gray-700 text-center">
                    Your reservation date is 
                    <span id="reservationDate" class="font-semibold text-blue-600">{{ date('l, F jS Y', strtotime($reservation->check_in)) }}</span>
                </p>
                <input type="hidden" value="{{ $reservation->created_at }}" id="createdDate">
                <input type="hidden" value="{{ $reservation->check_in }}" id="checkInDate">
                <div id="countdown" class="text-lg md:text-2xl font-bold text-red-500 mb-2 md:mb-4 text-center"></div>

                <!-- Go to renters page button -->
                <a href="{{ route('reserve.update', ['id' => Auth::user()->id, 'apartment' => $reservation->apartment_id, 'reservation' => $reservation->reservation_id]) }}">
                    <button id="doneButton" class="hidden bg-blue-500 hover:bg-blue-600 text-white px-4 md:px-6 py-2 md:py-3 rounded-md font-semibold w-full">Go to Renters Page</button>
                </a>
            </div>
        </div>
    </div>
    @endif

    @if(Auth::user()->role === 'pending')
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50">    
        <div class="bg-white p-4 md:p-8 rounded-lg shadow-lg w-11/12 md:w-3/4 lg:w-1/2">
            <h1 class="text-2xl md:text-3xl font-bold mb-4 md:mb-6 text-gray-800 text-center">Payment Under Review</h1>
            <p class="text-base md:text-lg mb-2 md:mb-4 text-gray-600 text-center">Please wait patiently for access to the renters module.</p>
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
            const cancelButton = document.getElementById('cancelButton');
            if (cancelButton) {
                cancelButton.style.display = 'none';
            }
        }

        // Carousel functionality
        const carouselItems = document.querySelectorAll('.carousel-item');
        const prevButton = document.getElementById('prevButton');
        const nextButton = document.getElementById('nextButton');
        let currentIndex = 0;

        function showCarouselItem(index) {
            carouselItems.forEach((item, i) => {
                item.classList.toggle('hidden', i !== index);
            });
        }

        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + carouselItems.length) % carouselItems.length;
            showCarouselItem(currentIndex);
        });

        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % carouselItems.length;
            showCarouselItem(currentIndex);
        });

        showCarouselItem(currentIndex);
    };
</script>
