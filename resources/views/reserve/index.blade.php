@section('title', '')
@include('layouts-renter.app')

@foreach ($apartment as $data)
@foreach ($category as $info)
<div class="container mx-auto p-4">
    <div class="bg-white shadow-md rounded px-8 py-6">
        <div class="mb-4">
            <h2 class="text-lg font-bold">Apartment Reservation Receipt</h2>
            <p class="text-gray-500">Please review your reservation details:</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Full Name
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Enter your full name">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                Email Address
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" placeholder="Enter your email address">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="apartment">
                Apartment Type
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"value="{{$info->name}}" readonly>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="pricePerMonth">
                Price Per Month ($)
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="pricePerMonth" type="number" min="0" step="0.01"value="{{$data->price}}"readonly>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="checkin">
                Check-In Date
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="checkin" type="date">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="checkout">
                Check-Out Date
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="checkout" type="date">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="totalPrice">
                Total Price
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="totalPrice" type="text" readonly>
            <span id="chargeMessage" class="text-red-500"></span>
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" onclick="calculateTotalPrice()">
                Confirm Reservation
            </button>
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                Cancel
            </a>
        </div>
    </div>
</div>
@endforeach
@endforeach
<script>
    document.getElementById('checkin').addEventListener('change', calculateTotalPrice);
    document.getElementById('checkout').addEventListener('change', calculateTotalPrice);
    document.getElementById('apartment').addEventListener('change', calculateTotalPrice);
    document.getElementById('pricePerMonth').addEventListener('input', calculateTotalPrice);

    function calculateTotalPrice() {
        // Calculate total price based on reservation details
        const checkinDate = new Date(document.getElementById('checkin').value);
        const checkoutDate = new Date(document.getElementById('checkout').value);
        const pricePerMonth = parseFloat(document.getElementById('pricePerMonth').value);

        // Ensure price per month is valid and not empty
        if (!document.getElementById('pricePerMonth').value || isNaN(pricePerMonth) || pricePerMonth <= 0) {
            return;
        }

        // Calculate total number of months
        const diffMonths = Math.ceil((checkoutDate - checkinDate) / (1000 * 60 * 60 * 24 * 30));

        // Display total price based on the actual number of months stayed
        document.getElementById('totalPrice').value = '$' + (pricePerMonth * diffMonths).toFixed(2);

        // Ensure minimum reservation period of 1 month
        if (diffMonths < 1) {
            document.getElementById('chargeMessage').textContent = "You will be charged for 1 month.";
        } else {
            document.getElementById('chargeMessage').textContent = "";
        }
    }
</script>